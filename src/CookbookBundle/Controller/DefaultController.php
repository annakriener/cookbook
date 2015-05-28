<?php

namespace CookbookBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
class DefaultController extends Controller {
    /**
     * @Route("/test", name="test")
     */
    public function indexAction() {
        return $this->render('CookbookBundle:default:base.html.twig');
        //return new Response("Default");
    }

    /**
     * @Route("/default/default", name="test2")
     */
    public function recipeAction() {
        //return $this->render('CookbookBundle:recipe:recipe.html.twig');
        return new Response("Default default");
    }
}
