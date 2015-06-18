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
        $em = $this->getDoctrine()->getManager();

        $endSnack = $startBreakfast = mktime(5, 0, 0);
        $endBreakfast = $startMainDish = mktime(10, 0, 0);
        $endMainDish = $startSnack = mktime(20, 0, 0);
        $currentTime = localtime(time(), true);

        var_dump($currentTime);

        if($startBreakfast <= $currentTime && $endBreakfast > $currentTime) {
            $recipes = $em->getRepository('CookbookBundle:Recipe')->findRecipesByCategory('breakfast', 3);
        } else if ($startMainDish <= $currentTime && $endMainDish > $currentTime) {
            $recipes =$em->getRepository('CookbookBundle:Recipe')->findRecipesByCategory('main dish', 3);
        } else if ($startSnack <= $currentTime && $endSnack > $currentTime) {
            $recipes = $em->getRepository('CookbookBundle:Recipe')->findRecipesByCategory('snack', 3);
        } else {
            $recipes = $em->getRepository('CookbookBundle:Recipe')->findDefaultRecipes();
        }

        $searchForm = $this->createForm(new SearchType(), null, array(
            'action' => $this->generateUrl('search'),
            'method' => 'POST'
        ));

        $searchRefineForm = $this->createForm(new SearchRefineType(), null, array(
            'action' => $this->generateUrl('search'),
            'method' => 'POST'
        ));

        return $this->render('CookbookBundle:default:base.html.twig', array(
            'recipes' => $recipes,
            'searchForm' => $searchForm->createView(),
            'searchRefineForm' =>$searchRefineForm->createView(),
        ));
    }

    /**
     * @Route("/recipe/{id}", name="recipe_detail")
     */
    public function getRecipeAction($id)
    {
        $recipe = $this->getDoctrine()->getRepository('CookbookBundle:Recipe')->find($id);
        $duration = $recipe->getDuration();
        $duration = date_format($duration, 'H:i:s');
        $ingredients = $recipe->getIngredients();

        $user = $this->getUser();
        $recipeAnnotations = $this->getDoctrine()
            ->getRepository('CookbookBundle:RecipeAnnotation')
            ->findOneBy(array('recipe' => $recipe, 'user_id' => $user));

        return $this->render('CookbookBundle:recipe-output-system:recipe.html.twig', array(
            'recipe' => $recipe,
            'duration' => $duration,
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
                    // VERSION 2
                    // prepared to store different data structure
                    $shoppingListEntry = array();
                    $shoppingListEntry[] = array("type" => 7, "checked" => false);
                    $shoppingListEntry[] = array("type" => 1, "txt" => $addToShoppingListItem);
                    $shoppingList[] = $shoppingListEntry;

                    // VERSION 1
                    //$shoppingList[] = $addToShoppingListItem;
                }

                $user->setShoppingList($shoppingList);
                $em->flush();
            }
        }
        return $this->redirect('/recipe/' . $id);
    }
}