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
    public function saveAnnotationsAction() {

        $user = $this->getUser();
        if (!$user) { return new Response();} // do not save if no user logged in

        $annotationID = $_POST['annotation_id'];
        $instr = $_POST['instructions'];
        $ingr = $_POST['ingredients'];
        $hide = ($_POST['hideCrossed'] == "true");

        $recipeAnnotation = $this->getDoctrine()->getManager()->getRepository('CookbookBundle:RecipeAnnotation')->findOneById($annotationID);

        if (!$recipeAnnotation) {
            $recID = intval($_POST['recipe_id']);
            $recipeAnnotation = new RecipeAnnotation();
            $recipe = $this->getDoctrine()->getManager()->getRepository('CookbookBundle:Recipe')->findOneById($recID);
            $recipeAnnotation->setRecipe($recipe);
            $recipeAnnotation->setUserId($user);
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

    /**
     * @Route("/removeAnnotations", name="removeAnnotations")
     */
    public function removeAnnotationsAction(){
        $user = $this->getUser();
        if (!$user) { return new Response();} // do not save if no user logged in

        $annotationID = $_POST['annotation_id'];

        $recipeAnnotation = $this->getDoctrine()->getManager()->getRepository('CookbookBundle:RecipeAnnotation')->findOneById($annotationID);

        if ($recipeAnnotation){
            $em = $this->getDoctrine()->getEntityManager();
            $em->remove($recipeAnnotation);
            $em->flush();
        }

        return new Response();
    }
}