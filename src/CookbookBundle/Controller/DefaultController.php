<?php

namespace CookbookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
}
