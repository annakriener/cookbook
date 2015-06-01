<?php

namespace CookbookBundle\Controller;


use CookbookBundle\Entity\RecipeAnnotation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route; // do not delete this line!
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonDecode;


class RecipeAnnotationController extends Controller {
    /**
     * @Route("/saveAnnotations", name="saveAnnotations")
     */
    public function saveAnnotations() {

        $annotationID = $_POST['annotation_id'];
        $instr = $_POST['instructions'];
        $ingr = $_POST['ingredients'];
        $hide = ($_POST['hideCrossed'] == "true");

        $recipeAnnotation = $this->getDoctrine()->getManager()->getRepository('CookbookBundle:RecipeAnnotation')->findOneById($annotationID);

        if (!$recipeAnnotation) {

            $recID = intval($_POST['recipe_id']);
            $userID = intval($_POST['user_id']);
            $recipeAnnotation = new RecipeAnnotation();

            $recipe = $this->getDoctrine()->getManager()->getRepository('CookbookBundle:Recipe')->findOneById($recID);
            //$user = $this->getDoctrine()->getManager()->getRepository('CookbookBundle:User')->findOneById($userID);
            $recipeAnnotation->setRecipe($recipe);
            $recipeAnnotation->setUserId($userID);
        }
        $recipeAnnotation->setInstructions($instr);
        $recipeAnnotation->setIngredients($ingr);

        $recipeAnnotation->setHideCrossed($hide);

        $em = $this->getDoctrine()->getManager();
        $em->persist($recipeAnnotation);
        $em->flush();


        // ACHTUNG, jedes echo oder error ist wird vor die response angehängt und ist genauso eine response
        return new Response($recipeAnnotation->getId());//, Response::HTTP_OK);
    }
}