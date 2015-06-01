<?php

namespace CookbookBundle\Controller;

use CookbookBundle\Form\Type\AddShoppingListItemType;
use CookbookBundle\Form\Type\DeleteShoppingListItemType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;

class ShoppingListController extends Controller {

    /**
     * @Route("/shoppinglist", name="shopping_list")
     */
    public function getShoppingListAction() {
        $addShoppingListItemForm = $this->createForm(new AddShoppingListItemType(), null, array(
            'action' => $this->generateUrl('shopping_list_add'),
            'method' => 'POST'
        ));

        $deleteShoppingListItemForm = $this->createForm(new DeleteShoppingListItemType(), null, array(
            'action' => $this->generateUrl('shopping_list_delete'),
            'method' => 'POST'
        ));

        $this->deleteCheckedShoppingListItem();
        $this->deleteAllShoppingListItems();

        $user = $this->getUser();
        $userShoppingList = $user->getShoppingList();

        return $this->render('CookbookBundle:shopping-list:shoppingList.html.twig', array(
            'userShoppingList' => $userShoppingList,
            'addShoppingListItemForm' => $addShoppingListItemForm->createView(),
            'deleteShoppingListItemForm' => $deleteShoppingListItemForm->createView()
        ));
    }

    /**
     * @Route("/shoppinglist/add", name="shopping_list_add")
     */
    public function addShoppingListItemAction(Request $request) {
        $addShoppingListItemForm = $this->createForm(new AddShoppingListItemType());

        if ($request->getMethod() == "POST") {

            if ($request->request->has("addShoppingListItem")) {
                $addShoppingListItemForm->handleRequest($request);

                if ($addShoppingListItemForm->isValid()) {
                    $data = $addShoppingListItemForm->getData();

                    $em = $this->getDoctrine()->getManager();
                    $user = $em->getRepository('CookbookBundle:User')->find($this->getUser()->getId());

                    $shoppingList = $user->getShoppingList();
                    $shoppingList[] = $data['item'];
                    $user->setShoppingList($shoppingList);
                    $em->flush();
                }
            }
        }
        return $this->redirectToRoute('shopping_list');
    }

    /**
     * @Route("/shoppinglist/delete", name="shopping_list_delete")
     */
    public function deleteShoppingListItemAction(Request $request) {
        $deleteShoppingListItemForm = $this->createForm(new DeleteShoppingListItemType());

        if ($request->getMethod() == "POST") {
            if($request->request->has("deleteShoppingListItem")) {
                $deleteShoppingListItemForm->handleRequest($request);

                if($deleteShoppingListItemForm->isValid()) {
                    if($deleteShoppingListItemForm->get('deleteItem')->isClicked()) {

                    }

                    if($deleteShoppingListItemForm->get('deleteAll')->isClicked()) {

                    }
                }
            }
        }
        return $this->redirectToRoute('shopping_list');
    }

    private function deleteCheckedShoppingListItem()
    {
        $request = $this->getRequest();
        $user = $this->getUser();

        if ($user) {
            $id = $user->getId();

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('CookbookBundle:User')->find($id);

            $shoppingList = $user->getShoppingList();
            if ($request->getMethod() == 'POST') {
                if ($request->request->has("deleteCheckedUserShoppingListItem")) {
                    $formData = $request->request->all("deleteCheckedUserShoppingListItemForm");

                    foreach ($formData as $item) {
                        if (($key = array_search($item, $shoppingList)) !== false) {
                            unset($shoppingList[$key]);
                        }
                    }
                    $user->setShoppingList($shoppingList);
                    $em->flush();
                }
            }
        }
    }

    private function deleteAllShoppingListItems()
    {
        $request = $this->getRequest();
        $user = $this->getUser();

        if ($user) {
            $id = $user->getId();

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('CookbookBundle:User')->find($id);

            if ($request->getMethod() == 'POST') {
                if ($request->request->has("deleteAllUserShoppingListItems")) {
                    $sl = array();
                    $user->setShoppingList($sl);
                    $em->flush();
                }
            }
        }
    }
}