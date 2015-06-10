<?php
/**
 * Created by PhpStorm.
 * User: Anna Kriener
 * Date: 10.06.2015
 * Time: 18:44
 */

namespace CookbookBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('search', 'search', array(
            'label' => false,
            'attr' => array(
                'placeholder' =>"Search for ...")
            )
        );
    }

    public function getName() {
        return 'search';
    }
}