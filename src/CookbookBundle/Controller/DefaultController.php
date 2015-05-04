<?php

namespace CookbookBundle\Controller;

use CookbookBundle\Entity\Recipe;
use CookbookBundle\Entity\Category;
use CookbookBundle\Form\Type\CategoryType;
use CookbookBundle\Form\Type\RecipeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

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
    public function addRecipeAction(Request $request) {
        // create a recipe
        $recipe = new Recipe();
        $category = new Category();

        // create a new form of type Recipe
        $form = $this->createForm(new RecipeType(), $recipe);
        $categoryForm = $this->createForm(new CategoryType(), $category);

        $form->handleRequest($request);
        $categoryForm->handleRequest($request);

        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            $em = $this->getDoctrine()->getManager();
            $em->persist($recipe);
            $em->flush();

            return $this->redirectToRoute('recipe');
        }

        if ($categoryForm->isValid()) {
            // perform some action, such as saving the task to the database
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('addRecipe');
        }

        return $this->render('CookbookBundle:recipe:addRecipe.html.twig', array(
            'form' => $form->createView(), 'categoryForm' => $categoryForm->createView()
        ));
    }
}
