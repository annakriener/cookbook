<?php
namespace CookbookBundle\Form\Type;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecipeType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', 'text', array('label' => 'Title: ', 'trim' => true))
            ->add('author', 'text', array('label' => 'Author: ', 'trim' => true))
            ->add('source', 'text', array('label' => 'Source: ', 'trim' => true))
            ->add('duration', 'time', array('label' => 'Duration: (hh:mm)'))

            ->add('category', 'entity', array(
                'class'         => 'CookbookBundle:Category',
                'property'      =>  'name',
                'query_builder'      => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                'label'         => 'Category: ',
                'placeholder'   => 'Choose a category',
                'empty_data'    => 'null'
            ))

            ->add('tags', 'collection', array(
                'type'          => new RecipeTagType(),
                'label'         => 'Tags:',
                'prototype'     => true,
                'allow_add'     => true,
                'allow_delete'  => true,
                'delete_empty'  => true,
                'by_reference'  => false,
                'options' => array('label' => false)
            ))

            ->add('ingredients', 'collection', array(
                'type'          => new RecipeIngredientType(),
                'label'         => 'Ingredients:',
                'prototype'     => true,
                'allow_add'     => true,
                'allow_delete'  => true,
                'delete_empty'  => true,
                'by_reference'  => false,
                'options' => array('label' => false)
            ))

            ->add('servings', 'integer', array('label' => 'Yields:', 'trim' => true))
            ->add('preparation', 'textarea', array('label' => 'Preparation:', 'trim' => true))

            ->add('instructions', 'collection', array(
                'type'          => 'textarea',
                'label'         => 'Instructions:',
                'prototype'     => true,
                'allow_add'     => true,
                'allow_delete'  => true,
                'delete_empty'  => true,
                'by_reference'  => false,
                'options' => array('label' => "Step:")
            ))

            ->add('image', 'file', array('label' => 'Image: '))
            ->add('save', 'submit', array('label' => 'Create Recipe'));
    }

    /*
     * getName() method returns the identifier of this form "type".
     * These identifiers must be unique in the application.
     * */
    public function getName() {
        return 'recipe';
    }

    /*
     * Every form needs to know the name of the class that holds the underlying data.
     * It's generally a good idea to explicitly specify the data_class option.
     * */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'CookbookBundle\Entity\Recipe',
        ));
    }
}