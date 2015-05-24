<?php

namespace CookbookBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecipeTagType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            /*
            ->add('tag', 'collection', array(
                'type'          => new TagType(),
                'prototype'     => true,
                'by_reference'  => false
            ))
            */
            ->add('tag', new TagType())
            ->add('classification', 'entity', array(
                'class'         => 'CookbookBundle:Classification',
                'property'      => 'name',
                'label'         => 'Classification: ',
                'placeholder'   => 'Choose a Classification',
                'empty_data'    => 'null',
                'required'      => false
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'CookbookBundle\Entity\RecipeTag',
        ));
    }

    public function getName() {
        return 'recipeTag';
    }
}