<?php

namespace CookbookBundle\Controller;

use CookbookBundle\Form\Type\AddShoppingListItemType;
use CookbookBundle\Form\Type\DeleteShoppingListItemType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;

class ShoppingListController extends Controller
{

    /**
     * @Route("/shoppinglist", name="shopping_list")
     */
    public function getShoppingListAction()
    {
        $user = $this->getUser();
        $userShoppingList = $user->getShoppingList();

        $addShoppingListItemForm = $this->createForm(new AddShoppingListItemType(), null, array(
            'action' => $this->generateUrl('shopping_list_add'),
            'method' => 'POST'
        ));

        $deleteShoppingListItemForm = $this->createForm(new DeleteShoppingListItemType($userShoppingList), null, array(
            'action' => $this->generateUrl('shopping_list_delete'),
            'method' => 'POST'
        ));

        return $this->render('CookbookBundle:shopping-list:shoppingList.html.twig', array(
            'userShoppingList' => $userShoppingList,
            'addShoppingListItemForm' => $addShoppingListItemForm->createView(),
            'deleteShoppingListItemForm' => $deleteShoppingListItemForm->createView()
        ));
    }

    /**
     * @Route("/shoppinglist/add", name="shopping_list_add")
     */
    public function addShoppingListItemAction(Request $request)
    {
        $addShoppingListItemForm = $this->createForm(new AddShoppingListItemType());

        if ($request->isMethod('POST')) {

            if ($request->request->has("addShoppingListItem")) {
                $addShoppingListItemForm->handleRequest($request);

                if ($addShoppingListItemForm->isValid()) {
                    $data = $addShoppingListItemForm->getData();

                    $em = $this->getDoctrine()->getManager();
                    $user = $em->getRepository('CookbookBundle:User')->find($this->getUser()->getId());

                    $shoppingList = $user->getShoppingList();

                    $shoppingListEntry = array();
                    $shoppingListEntry[] = array("type" => 7, "checked" => false);
                    $shoppingListEntry[] = array("type" => 1, "txt" => $data["item"]);
                    $shoppingList[] = $shoppingListEntry;

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
    public function deleteShoppingListItemAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('CookbookBundle:User')->find($this->getUser()->getId());
        $shoppingList = $user->getShoppingList();
        $deleteShoppingListItemForm = $this->createForm(new DeleteShoppingListItemType($shoppingList));

        if ($request->getMethod() == "POST") {
            if ($request->request->has("deleteShoppingListItem")) {
                $deleteShoppingListItemForm->handleRequest($request);

                if ($deleteShoppingListItemForm->isValid()) {

                    // if user clicks button "delete checked item"
                    if ($deleteShoppingListItemForm->get('deleteItem')->isClicked()) {
                        $data = $deleteShoppingListItemForm->getData();
                        $item_keys = $data["items"];

                        foreach ($item_keys as $key) {
                            unset($shoppingList[$key]);
                        }
                        // is necessary to keep right data structure
                        $shoppingList = array_values($shoppingList);

                        $user->setShoppingList($shoppingList);
                        $em->flush();
                    }

                    // if user clicks button "delete all"
                    if ($deleteShoppingListItemForm->get('deleteAll')->isClicked()) {
                        $shoppingList = array();

                        $user->setShoppingList($shoppingList);
                        $em->flush();
                    }
                }
            }
        }
        return $this->redirectToRoute('shopping_list');
    }

    /**
     * @Route("/shoppinglist/check", name="shopping_list_item_check")
     */
    public function setShoppingListItemCheckedStatusAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('CookbookBundle:User')->find($this->getUser()->getId());
        $shoppingList = $user->getShoppingList();

        if($request->isXmlHttpRequest()) {

            $index = $request->get('index');
            $isChecked = filter_var($request->get('isChecked'), FILTER_VALIDATE_BOOLEAN);

            $shoppingList[$index][0]["checked"] = $isChecked;

            $user->setShoppingList($shoppingList);
            $em->flush();
        }

        return $this->redirectToRoute('shopping_list');
    }


    /**
     * @Route("/shoppinglist/edit", name="shopping_list_item_edit")
     */
    public function editShoppingListItemAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('CookbookBundle:User')->find($this->getUser()->getId());
        $shoppingList = $user->getShoppingList();

        if($request->isXmlHttpRequest()) {

            $index = $request->get('index');
            $newValue = $request->get('newValue');

            $shoppingList[$index][1]["txt"] = $newValue;

            $user->setShoppingList($shoppingList);
            $em->flush();
        }

        return $this->redirectToRoute('shopping_list');
    }
}