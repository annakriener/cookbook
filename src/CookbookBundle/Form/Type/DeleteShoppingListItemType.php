<?php
/**
 * Created by PhpStorm.
 * User: Anna Kriener
 * Date: 01.06.2015
 * Time: 09:54
 */

namespace CookbookBundle\Form\Type;


use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use Symfony\Component\Form\FormBuilderInterface;

class DeleteShoppingListItemType extends AbstractType{

    // VERSION 2
    // prepared to store different data structure
    private $shoppingListItems;
    private $checkedItemsById;

    // VERSION 1
    //private $shoppingList;

    public function __construct($shoppingList) {
        // VERSION 2
        // prepared to store different data structure
        $this->shoppingListItems = array();
        $this->checkedItemsById = array();

        for($i = 0; $i < count($shoppingList); $i++) {
            $this->shoppingListItems[] = $shoppingList[$i][1]["txt"];
            if($shoppingList[$i][0]["checked"]) {
                $this->checkedItemsById[] = $i;
            }
        }

        // VERSION 1
        //$this->shoppingList = $shoppingList;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('items', 'choice', array(
                // VERSION 1
                //'choices' => $this->shoppingList,
                // VERSION 2
                'choices' => $this->shoppingListItems,
                'multiple' => true,
                'expanded' => true,
                'label' => false,
                // VERSION 2
                'data' => $this->checkedItemsById
            ))
            ->add('deleteItem', 'submit', array('label' => 'Delete checked items'))
            ->add('deleteAll', 'submit', array('label' => 'Delete all'));
    }

    public function getName() {
        return 'deleteShoppingListItem';
    }
}