<?php

namespace CookbookBundle\Controller;


use CookbookBundle\Entity\RecipeAnnotation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Serializer\Encoder\JsonDecode;


class RecipeAnnotationController extends Controller {
    /**
     * @Route("/saveAnnotations", name="saveAnnotations")
     */
    public function saveAnnotations() {
        echo "hello !!";
        // create new entities
        $recipeAnnotation = new RecipeAnnotation();
        $recID = intval($_POST['recipe_id']);
        $userID = intval($_POST['user_id']);
        $instr = $_POST['instructions'];
       // $instrJS = decode($instr);
        $ingredient = $_POST['ingredients'];

        echo "recipe id:";
        var_dump($recID);
        echo "user id:";
        var_dump($userID);
        echo "instructions:  ";
        var_dump($instr);

        $recipeAnnotation->setRecipe($recID);
        $recipeAnnotation->setUserId($userID);

        $recipeAnnotation->setInstructions($instr);
        $recipeAnnotation->setIngredients($ingredient);

        $em = $this->getDoctrine()->getManager();
        $em->persist($recipeAnnotation);
        $em->flush();
        /*
         *         recipe_id : recipe_id,
        user_id : user,
        instructions : serializedInstructions,
        ingredients : serializedIngredients*/

        //if ($request->isMethod('POST')) {

           // $recipeAnnotation->setRecipe($request->get("recipe_id"));
           // $recipeAnnotation->setIngredients($request->get("ingredients"));
           // $recipeAnnotation->setInstructions($request->get("instructions"));

        return new Response($recipeAnnotation->getId(), Response::HTTP_OK);

       // }
    }
}