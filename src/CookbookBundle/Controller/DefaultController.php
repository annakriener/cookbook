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
        $recipeForm = $this->createForm(new RecipeType(), $recipe);
        $categoryForm = $this->createForm(new CategoryType(), $category);

        if($request->isMethod('POST')) {
            if($request->request->has('recipe')) {
                $recipeForm->handleRequest($request);
                if ($recipeForm->isValid()) {
                    // perform some action, such as saving the task to the database
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($recipe);
                    $em->flush();

                    return $this->redirectToRoute('addRecipe');
                }

            }

            if($request->request->has('category')) {
                $categoryForm->handleRequest($request);
                if ($categoryForm->isValid()) {
                    // perform some action, such as saving the task to the database
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($category);
                    $em->flush();

                    return $this->redirectToRoute('addRecipe');
                }
            }
        }

        return $this->render('CookbookBundle:recipe-input-system:base.html.twig', array(
            'recipeForm' => $recipeForm->createView(),
            'categoryForm' => $categoryForm->createView()
        ));
    }
}
