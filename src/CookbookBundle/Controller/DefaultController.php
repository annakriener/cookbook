<?php

namespace CookbookBundle\Controller;

use CookbookBundle\Entity\Recipe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller {
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction() {
        return $this->render('CookbookBundle:default:base.html.twig');
    }

    /**
     * @Route("/recipe", name="recipe")
     */
    public function recipeAction() {
        return $this->render('CookbookBundle:recipe:recipe.html.twig');
    }

    /**
     * @Route("/addRecipe", name="addRecipe")
     */
    public function addRecipeAction() {
        // create a recipe and give it some dummy data for this example
        $recipe = new Recipe();
        $form = $this->createFormBuilder($recipe)
            ->add('title', 'text')
            ->add('author', 'text')
            ->add('source', 'text')
            ->add('duration', 'text')
            ->add('servings', 'text')
            ->add('preparation', 'textarea')
            ->add('instruction', 'textarea')
            ->add('imageURL', 'text')
            ->add('save', 'submit', array('label' => 'Create Recipe'))
            ->getForm();
        return $this->render('CookbookBundle:recipe:addRecipe.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
