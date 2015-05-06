<?php

namespace CookbookBundle\Controller;

use CookbookBundle\Entity\Recipe;
use CookbookBundle\Entity\Category;
use CookbookBundle\Entity\Measurement;
use CookbookBundle\Entity\Classification;
use CookbookBundle\Entity\Ingredient;

use CookbookBundle\Entity\RecipeIngredientReference;
use CookbookBundle\Entity\RecipeTagReference;
use CookbookBundle\Entity\Tag;
use CookbookBundle\Form\Type\TagType;
use CookbookBundle\Form\Type\IngredientType;
use CookbookBundle\Form\Type\RecipeType;
use CookbookBundle\Form\Type\CategoryType;
use CookbookBundle\Form\Type\MeasurementType;
use CookbookBundle\Form\Type\ClassificationType;

use Doctrine\Common\Collections\ArrayCollection;
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

        $ingredient = new Ingredient();
        $tag = new Tag();

        $recipe_ingredient_reference = new RecipeIngredientReference();
        $recipe_tag_reference = new RecipeTagReference();

        $recipe_ingredient_reference->setRecipe($recipe);
        $recipe_tag_reference->setRecipe($recipe);

        $recipe->addRecipeIngredientReference($recipe_ingredient_reference);
        $recipe->addRecipeTagReference($recipe_tag_reference);

        // create a new form of type Recipe
        $recipeForm = $this->createForm(new RecipeType(), $recipe);
        $categoryForm = $this->createForm(new CategoryType(), $category);
        $measurementForm = $this->createForm(new MeasurementType(), $measurement);
        $classificationForm = $this->createForm(new ClassificationType(), $classification);

        $ingredientForm = $this->createForm(new IngredientType(), $ingredient);
        $tagForm = $this->createForm(new TagType(), $tag);

        $recipe_ingredient_reference->setIngredient($ingredient);
        $recipe_tag_reference->setTag($tag);

        if($request->isMethod('POST')) {
            if($request->request->has('recipe')) {
                $recipeForm->handleRequest($request);
                $ingredientForm->handleRequest($request);
                $tagForm->handleRequest($request);
                if ($recipeForm->isValid()) {
                    // saving the recipe to the database
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($recipe);
                    $em->persist($recipe_ingredient_reference);
                    $em->persist($recipe_tag_reference);
                    $em->persist($ingredient);
                    $em->persist($tag);
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
            'classificationForm' => $classificationForm->createView(),
            'ingredientForm' => $ingredientForm->createView(),
            'tagForm' => $tagForm->createView()
        ));
    }


}
