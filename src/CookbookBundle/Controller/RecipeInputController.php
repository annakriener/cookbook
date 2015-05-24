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

class RecipeInputController extends Controller {
    /**
     * @Route("/addRecipe", name="addRecipe")
     */
    public function addRecipeAction(Request $request) {
        // create new entities
        $recipe = new Recipe();
        //$ingredient = new Ingredient();
        $category = new Category();
        $measurement = new Measurement();
        $classification = new Classification();

        //$recipe_ingredient = new RecipeIngredient();
        //$recipe_tag = new RecipeTag();

        // set recipe in relational entities
        //$recipe_ingredient->setRecipe($recipe);
        //$recipe_tag->setRecipe($recipe);

        // set relational ingredients and tags in recipe
        //$recipe->addIngredient($recipe_ingredient);
        //$recipe->addTag($recipe_tag);

        // create new forms
        $recipeForm = $this->createForm(new RecipeType(), $recipe);
        //$ingredientForm = $this->createForm(new IngredientType(), $ingredient);
        $categoryForm = $this->createForm(new CategoryType(), $category);
        $measurementForm = $this->createForm(new MeasurementType(), $measurement);
        $classificationForm = $this->createForm(new ClassificationType(), $classification);

        // set ingredient and tag in relational entities
        //$recipe_ingredient->setIngredient($ingredient);

        if($request->isMethod('POST')) {
            if($request->request->has('recipe')) {

                $recipeForm->handleRequest($request);
                //$ingredientForm->handleRequest($request);

                if ($recipeForm->isValid() /*&& $ingredientForm->isValid()*/) {
                    // saving the recipe to the database
                    $em = $this->getDoctrine()->getManager();

                    $em->persist($recipe);
                    //$em->persist($recipe_ingredient);
                    //$em->persist($recipe_tag);
                    //$em->persist($ingredient);
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
                    // saving the measurement to the database
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($measurement);
                    $em->flush();

                    return $this->redirectToRoute('addRecipe');
                }
            }

            if($request->request->has('classification')) {
                $classificationForm->handleRequest($request);
                if ($classificationForm->isValid()) {
                    // saving the classification to the database
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($classification);
                    $em->flush();

                    return $this->redirectToRoute('addRecipe');
                }
            }
        }

        return $this->render('CookbookBundle:recipe-input-system:base.html.twig', array(

            'recipeForm' => $recipeForm->createView(),
            //'ingredientForm' => $ingredientForm->createView(),
            'categoryForm' => $categoryForm->createView(),
            'measurementForm' => $measurementForm->createView(),
            'classificationForm' => $classificationForm->createView(),
        ));
    }
}
