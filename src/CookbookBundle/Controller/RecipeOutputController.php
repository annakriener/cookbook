<?php

namespace CookbookBundle\Controller;

use CookbookBundle\Form\Type\SearchRefineType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use CookbookBundle\Form\Type\SearchType;

class RecipeOutputController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function getRecipesAction()
    {
        $resultByTime = $this->getResultByTime();
        $recipesByTime = $resultByTime['recipes'];
        $categoryByTime = $resultByTime['category'];

        $resultBySeason = $this->getResultBySeason();
        $recipesBySeason = $resultBySeason['recipes'];
        $season = $resultBySeason['season'];

        $searchForm = $this->createForm(new SearchType(), null, array(
            'action' => $this->generateUrl('search'),
            'method' => 'POST'
        ));

        $searchRefineForm = $this->createForm(new SearchRefineType(), null, array(
            'action' => $this->generateUrl('search'),
            'method' => 'POST'
        ));

        return $this->render('CookbookBundle:default:base.html.twig', array(
            'categoryByTime' => $categoryByTime,
            'recipesByTime' => $recipesByTime,
            'season' => $season,
            'recipesBySeason' => $recipesBySeason,
            'searchForm' => $searchForm->createView(),
            'searchRefineForm' => $searchRefineForm->createView(),
        ));
    }

    /**
     * @Route("/recipe/{id}", name="recipe_detail")
     */
    public function getRecipeAction($id)
    {
        $recipe = $this->getDoctrine()->getRepository('CookbookBundle:Recipe')->find($id);
        $duration = $recipe->getDuration();
        $duration_hours = date_format($duration, 'G');
        $duration_minutes = intval(date_format($duration, 'i'));
        $source = $recipe->getSource();
        $isSourceURL = filter_var($source, FILTER_VALIDATE_URL);

        $source = ['text' => $source, 'isURL' => $isSourceURL];
        $ingredients = $recipe->getIngredients();

        $user = $this->getUser();
        $recipeAnnotations = $this->getDoctrine()
            ->getRepository('CookbookBundle:RecipeAnnotation')
            ->findOneBy(array('recipe' => $recipe, 'user_id' => $user));

        return $this->render('CookbookBundle:recipe-output-system:recipe.html.twig', array(
            'recipe' => $recipe,
            'duration_hours' => $duration_hours,
            'duration_minutes' => $duration_minutes,
            'source' => $source,
            'ingredients' => $ingredients,
            'annotations' => $recipeAnnotations
        ));
    }

    // add ingredients of recipes to user-shopping-list
    /**
     * @Route("/recipe/{id}/add/to/shoppinglist", name="recipe_add_to_shopping_list")
     */
    public function addToShoppingListAction($id, Request $request)
    {
        $user = $this->getUser();

        if ($user) {
            $user_id = $user->getId();

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('CookbookBundle:User')->find($user_id);

            $shoppingList = $user->getShoppingList();

            if ($request->getMethod() == 'POST') {
                $addToShoppingListFormData = $request->request->all();

                foreach ($addToShoppingListFormData as $addToShoppingListItem) {
                    $shoppingListEntry = array();
                    $shoppingListEntry[] = array("type" => 7, "checked" => false);
                    $shoppingListEntry[] = array("type" => 1, "txt" => $addToShoppingListItem);
                    $shoppingList[] = $shoppingListEntry;
                }

                $user->setShoppingList($shoppingList);
                $em->flush();
            }
        }
        return $this->redirect('/recipe/' . $id);
    }

    private function getResultByTime()
    {
        $em = $this->getDoctrine()->getManager();

        /*
        * breakfast: 5am - 9:59am
        * main-dish: 10am - 19:59pm
        * snack: 20pm - 4:59am
        */
        $endSnack = $startBreakfast = mktime(5, 0, 0);
        $endBreakfast = $startMainDish = mktime(10, 0, 0);
        $endMainDish = $startSnack = mktime(20, 0, 0);
        $currentTime = time();
        $recipes = null;
        $category = null;
        $resultLimit = 3;

        /* query recipes according to time */
        if ($this->isTimeBetween($startBreakfast, $endBreakfast, $currentTime)) {
            $category = 'breakfast';
            $recipes = $em->getRepository('CookbookBundle:Recipe')->findRecipesByCategory($category, $resultLimit);
        } else if ($this->isTimeBetween($startMainDish, $endMainDish, $currentTime)) {
            $category = 'main dish';
            $recipes = $em->getRepository('CookbookBundle:Recipe')->findRecipesByCategory($category, $resultLimit);
        } else if ($this->isTimeBetween($startSnack, $endSnack, $currentTime)) {
            $category = 'snack';
            $recipes = $em->getRepository('CookbookBundle:Recipe')->findRecipesByCategory($category, $resultLimit);
        }

        /* if there are not enough recipes for any time - query default recipes*/
        if (count($recipes) < 2) {
            $recipes = $em->getRepository('CookbookBundle:Recipe')->findDefaultRecipes();
        }

        return array('category' => $category, 'recipes' => $recipes);
    }

    private function getResultBySeason()
    {
        $em = $this->getDoctrine()->getManager();

        $day = date("z");
        $season = null;
        $recipes = null;
        $resultLimit = 3;

        /*
        * northern hemisphere
        * spring: 21. march - 20. june
        * summer: 21. june - 22. september
        * autumn: 23. september - 21. december
        * winter: 22. december - 20. march
        */
        $spring_starts = date("z", strtotime("March 21"));
        $spring_ends = date("z", strtotime("June 20"));
        $summer_starts = date("z", strtotime("June 21"));
        $summer_ends = date("z", strtotime("September 22"));
        $autumn_starts = date("z", strtotime("September 23"));
        $autumn_ends = date("z", strtotime("December 21"));

        //  If $day is between the days of spring, summer, autumn, and winter
        if ($this->isTimeBetween($spring_starts, $spring_ends, $day)) {
            $season = "spring";
            $recipes = $em->getRepository('CookbookBundle:Recipe')->findRecipesBySeason($season, $resultLimit);
        } elseif ($this->isTimeBetween($summer_starts, $summer_ends, $day)) {
            $season = "summer";
            $recipes = $em->getRepository('CookbookBundle:Recipe')->findRecipesBySeason($season, $resultLimit);
        } elseif ($this->isTimeBetween($autumn_starts, $autumn_ends, $day)) {
            $season = "autumn";
            $recipes = $em->getRepository('CookbookBundle:Recipe')->findRecipesBySeason($season, $resultLimit);
        } else {
            $season = "winter";
            $recipes = $em->getRepository('CookbookBundle:Recipe')->findRecipesBySeason($season, $resultLimit);
        }

        /* if there are not enough recipes for any season - query default recipes */
        if (count($recipes) < 2) {
            $recipes = $em->getRepository('CookbookBundle:Recipe')->findDefaultRecipes();
        }

        return array('season' => $season, 'recipes' => $recipes);
    }

    private function isTimeBetween($from, $to, $now)
    {
        if ($from > $to) {
            $to += strtotime('+1 day');
        }

        if($now < $from) {
            $now += strtotime('+1 day');
        }

        return ($from <= $now && $now < $to);
    }
}