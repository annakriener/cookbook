<?php

namespace CookbookBundle\Form\Type;
use Doctrine\ORM\EntityRepository;
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
            ->add('tag', new TagType(), array(
                'label' => false)
            )
            ->add('classification', 'entity', array(
                'class'         => 'CookbookBundle:Classification',
                'property'      => 'name',
                'query_builder'      => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                'label'         => 'Classification: ',
                'placeholder'   => 'Choose a Classification',
                'required'      => false,
                'empty_data'    => null
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