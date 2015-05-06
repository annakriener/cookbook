<?php

namespace CookbookBundle\Controller;

use CookbookBundle\Entity\Recipe;
use CookbookBundle\Entity\Category;
use CookbookBundle\Entity\Measurement;
use CookbookBundle\Entity\Classification;
use CookbookBundle\Entity\Ingredient;

use CookbookBundle\Entity\RecipeIngredientReference;
use CookbookBundle\Form\Type\RecipeType;
use CookbookBundle\Form\Type\CategoryType;
use CookbookBundle\Form\Type\MeasurementType;
use CookbookBundle\Form\Type\ClassificationType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class RecipeInputController extends Controller {
    /**
     * @Route("/addRecipe", name="addRecipe")
     */
    public function addRecipeAction(Request $request) {
        // create a recipe
        $recipe = new Recipe();
        $category = new Category();
        $measurement = new Measurement();
        $classification = new Classification();

        // create a new form of type Recipe
        $recipeForm = $this->createForm(new RecipeType(), $recipe);
        $categoryForm = $this->createForm(new CategoryType(), $category);
        $measurementForm = $this->createForm(new MeasurementType(), $measurement);
        $classificationForm = $this->createForm(new ClassificationType(), $classification);

        if($request->isMethod('POST')) {
            if($request->request->has('recipe')) {
                $recipeForm->handleRequest($request);
                if ($recipeForm->isValid()) {
                    // saving the recipe to the database
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($recipe);
                    $em->flush();

                    return $this->redirectToRoute('addRecipe');
                }

            }

            if($request->request->has('category')) {
                $categoryForm->handleRequest($request);
                if ($categoryForm->isValid()) {
                    // saving the category to the database
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($category);
                    $em->flush();

                    return $this->redirectToRoute('addRecipe');
                }
            }

            if($request->request->has('measurement')) {
                $measurementForm->handleRequest($request);
                if ($measurementForm->isValid()) {
                    // saving the category to the database
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($measurement);
                    $em->flush();

                    return $this->redirectToRoute('addRecipe');
                }
            }

            if($request->request->has('classification')) {
                $classificationForm->handleRequest($request);
                if ($classificationForm->isValid()) {
                    // saving the category to the database
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($classification);
                    $em->flush();

                    return $this->redirectToRoute('addRecipe');
                }
            }
        }

        return $this->render('CookbookBundle:recipe-input-system:base.html.twig', array(
            'recipeForm' => $recipeForm->createView(),
            'categoryForm' => $categoryForm->createView(),
            'measurementForm' => $measurementForm->createView(),
            'classificationForm' => $classificationForm->createView()
        ));
    }
}
