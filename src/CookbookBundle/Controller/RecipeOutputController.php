<?php

namespace CookbookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class RecipeOutputController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function getRecipesAction() {
        $em = $this->getDoctrine()->getManager();

        $recipes = $em->getRepository('CookbookBundle:Recipe')->findAllOrderedByTitle();

        return $this->render('CookbookBundle:default:base.html.twig', array(
            'recipes' => $recipes));
    }

    /**
     * @Route("/recipe/{id}", name="getRecipe")
     */
    public function getRecipeAction($id) {
        $recipe = $this->getDoctrine()->getRepository('CookbookBundle:Recipe')->find($id);
        $duration = $recipe->getDuration();
        $duration = date_format($duration, 'H:i:s');
        $ingredients = $recipe->getIngredients();

        // RECIPE ANNOTATION---
        $userID = 0; //TODO: use actual user ID
        $recipeAnnotations = $this->getDoctrine()
            ->getRepository('CookbookBundle:RecipeAnnotation')
            ->findOneBy(array('recipe' => $recipe, 'user_id' => $userID));
        //----



        return $this->render('CookbookBundle:recipe:recipe.html.twig', array(
            'recipe' => $recipe,
            'duration' => $duration,
            'ingredients' => $ingredients,
            'annotations' => $recipeAnnotations
        ));
    }
}