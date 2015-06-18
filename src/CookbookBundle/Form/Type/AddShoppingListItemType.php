<?php
/**
 * Created by PhpStorm.
 * User: Anna Kriener
 * Date: 01.06.2015
 * Time: 09:11
 */

namespace CookbookBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class AddShoppingListItemType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('item', 'text', array(
                'label' => false,
                'constraints' => array(new NotBlank())))
            ->add('save', 'submit', array('label' => 'Add item'));
    }

    public function getName() {
        return 'addShoppingListItem';
    }
}