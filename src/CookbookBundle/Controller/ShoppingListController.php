<?php

namespace CookbookBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ShoppingListController extends Controller {

    /**
     * @Route("/shoppinglist", name="shopping_list")
     */
    public function getShoppingListAction() {
        return $this->render('CookbookBundle:shopping-list:shoppingList.html.twig');
    }
}