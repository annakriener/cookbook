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
use Symfony\Component\Form\FormBuilderInterface;

class DeleteShoppingListItemType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('test', 'text')
            ->add('deleteItem', 'submit', array('label' => 'Delete checked items'))
            ->add('deleteAll', 'submit', array('label' => 'Delete all'));
    }

    public function getName() {
        return 'deleteShoppingListItem';
    }
}