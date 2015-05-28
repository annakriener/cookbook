<?php

namespace CookbookBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller {
    /**
     * @Route("/default", name="default")
     */
    public function indexAction() {
        //return $this->render('CookbookBundle:default:base.html.twig');

        return new Response("Default page");
    }

    /**
     * @Route("/default/default", name="default_default")
     */
    public function recipeAction() {
        //return $this->render('CookbookBundle:recipe:recipe.html.twig');

        return new Response("Default_default page");
    }
}
