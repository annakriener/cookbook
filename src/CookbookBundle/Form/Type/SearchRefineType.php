<?php
/**
 * Created by PhpStorm.
 * User: Anna Kriener
 * Date: 14.06.2015
 * Time: 16:35
 */

namespace CookbookBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchRefineType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', 'text', array(
                'label'         => 'Title',
                'attr'          => array(
                    'placeholder' => 'spaghetti bolognese'
                )
            ))
            ->add('category', 'entity', array(
                'class'         => 'CookbookBundle:Category',
                'property'      => 'name',
                'label'         => 'Category: ',
                'placeholder'   => 'Choose a category',
                'empty_data'    => 'null',
                'required'      => false
            ))
            ->add('ingredient1', 'text', array(
                'label'         => "Include Ingredients",
                'attr'          => array(
                    'placeholder' => "rice"
                ),
                'required'      => false
            ))
            ->add('ingredient2', 'text', array(
                'label'         => false,
                'attr'          => array(
                    'placeholder' => "tomato"
                ),
                'required'      => false
            ))
            ->add('ingredient3', 'text', array(
                'label'         => false,
                'attr'          => array(
                    'placeholder' => "chicken"
                ),
                'required'      => false
            ))
            ->add('tag1', 'text', array(
                'label'         => "Include Tags",
                'attr'          => array(
                    'placeholder' => "easy"
                ),
                'required'      => false
            ))
            ->add('tag2', 'text', array(
                'label'         => false,
                'attr'          => array(
                    'placeholder' => "spicy"
                ),
                'required'      => false
            ))
            ->add('tag3', 'text', array(
                'label'         => false,
                'attr'          => array(
                    'placeholder' => false
                ),
                'required'      => false
            ))
            ->add('image', 'checkbox', array(
                'label'         => 'with Photo',
                'required'      => false
            ));
    }

    public function getName() {
        return 'search';
    }
}