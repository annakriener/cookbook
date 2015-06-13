<?php

namespace CookbookBundle\Controller;

use CookbookBundle\Entity\Recipe;
use CookbookBundle\Entity\Category;
use CookbookBundle\Entity\Measurement;
use CookbookBundle\Entity\Classification;
use CookbookBundle\Entity\Ingredient;

use CookbookBundle\Entity\RecipeIngredient;
use CookbookBundle\Entity\RecipeTag;

use CookbookBundle\Form\Type\RecipeTagType;

use CookbookBundle\Form\Type\IngredientType;
use CookbookBundle\Form\Type\RecipeType;
use CookbookBundle\Form\Type\CategoryType;
use CookbookBundle\Form\Type\MeasurementType;
use CookbookBundle\Form\Type\ClassificationType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RecipeInputController extends Controller {
    /**
     * @Route("/addRecipe", name="add_recipe")
     */
    public function addRecipeAction(Request $request) {
        // create new entities
        $recipe = new Recipe();
        $category = new Category();
        $measurement = new Measurement();
        $classification = new Classification();

        $recipeForm = $this->createForm(new RecipeType(), $recipe, array(
            //'action' => $this->generateUrl('add_new_recipe'),
            //'method' => 'POST'));
        ));
        $categoryForm = $this->createForm(new CategoryType(), $category, array(
            'action' => $this->generateUrl('add_category'),
            'method' => 'POST'));
        $measurementForm = $this->createForm(new MeasurementType(), $measurement, array(
            'action' => $this->generateUrl('add_measurement'),
            'method' => 'POST'));
        $classificationForm = $this->createForm(new ClassificationType(), $classification, array(
            'action' => $this->generateUrl('add_classification'),
            'method' => 'POST'));

        if ($request->isMethod('POST')) {
            if ($request->request->has('recipe')) {
                $recipeForm->handleRequest($request);
                if ($recipeForm->isValid()) {
                    // saving the recipe to the database
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($recipe);
                    $em->flush();
                }
            }
        }

        return $this->render('CookbookBundle:recipe-input-system:recipeInput.html.twig', array(
            'recipeForm' => $recipeForm->createView(),
            'categoryForm' => $categoryForm->createView(),
            'measurementForm' => $measurementForm->createView(),
            'classificationForm' => $classificationForm->createView(),
        ));
    }

    /**
     * @Route("/addRecipe/addRecipe", name="add_new_recipe")
     */
    public function processRecipeFormAction(Request $request) {
        $recipe = new Recipe();
        $recipeForm = $this->createForm(new RecipeType(), $recipe);

        if ($request->isMethod('POST')) {
            if ($request->request->has('recipe')) {
                $recipeForm->handleRequest($request);
                if ($recipeForm->isValid()) {
                    // saving the recipe to the database
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($recipe);
                    $em->flush();
                }
            }
        }

        return $this->redirectToRoute('add_recipe');
    }

    /**
     * @Route("/addRecipe/addCategory", name="add_category")
     */
    public function processCategoryFormAction(Request $request) {
        $category = new Category();
        $categoryForm = $this->createForm(new CategoryType(), $category);

        if ($request->isMethod('POST')) {
            if ($request->request->has('category')) {
                $categoryForm->handleRequest($request);
                if ($categoryForm->isValid()) {
                    // saving the category to the database
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($category);
                    $em->flush();
                }
            }
        }

        return $this->redirectToRoute('add_recipe');
    }

    /**
     * @Route("/addRecipe/addMeasurement", name="add_measurement")
     */
    public function processMeasurementFormAction(Request $request) {
        $measurement = new Measurement();
        $measurementForm = $this->createForm(new MeasurementType(), $measurement);

        if ($request->isMethod('POST')) {
            if ($request->request->has('measurement')) {
                $measurementForm->handleRequest($request);
                if ($measurementForm->isValid()) {
                    // saving the measurement to the database
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($measurement);
                    $em->flush();
                }
            }
        }

        return $this->redirectToRoute('add_recipe');
    }

    /**
     * @Route("/addRecipe/addClassification", name="add_classification")
     */
    public function processClassificationFormAction(Request $request) {
        $classification = new Classification();
        $classificationForm = $this->createForm(new ClassificationType(), $classification);

        if ($request->isMethod('POST')) {
            if ($request->request->has('classification')) {
                $classificationForm->handleRequest($request);
                if ($classificationForm->isValid()) {
                    // saving the classification to the database
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($classification);
                    $em->flush();
                }
            }
        }

        return $this->redirectToRoute('add_recipe');
    }
}
