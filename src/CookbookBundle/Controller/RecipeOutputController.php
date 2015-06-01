<?php

namespace CookbookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class RecipeOutputController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function getRecipesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $recipes = $em->getRepository('CookbookBundle:Recipe')->findAllOrderedByTitle();

        return $this->render('CookbookBundle:default:base.html.twig', array(
            'recipes' => $recipes));
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

        $this->addToShoppingListAction();

        return $this->render('CookbookBundle:recipe-output-system:recipe.html.twig', array(
            'recipe' => $recipe,
            'duration' => $duration,
            'ingredients' => $ingredients,
        ));
    }

    // add ingredients of recipes to user-shopping-list
    private function addToShoppingListAction() {
        $request = $this->getRequest();
        $user = $this->getUser();

        if ($user) {
            $id = $user->getId();

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('CookbookBundle:User')->find($id);

            $shoppingList = $user->getShoppingList();

            if ($request->getMethod() == 'POST') {
                    $addToShoppingListFormData = $request->request->all();

                    foreach ($addToShoppingListFormData as $addToShoppingListItem) {
                        $shoppingList[] = $addToShoppingListItem;
                    }

                    $user->setShoppingList($shoppingList);
                    $em->flush();
                }
            }
        }
}