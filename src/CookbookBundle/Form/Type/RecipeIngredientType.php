<?php

namespace CookbookBundle\Form\Type;

use CookbookBundle\Entity\Ingredient;
use CookbookBundle\Entity\RecipeIngredientReference;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecipeIngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', 'number', array('label' => 'Quantity:', 'trim' => true))
            ->add('measurement', 'entity', array(
                'class'         => 'CookbookBundle:Measurement',
                'property'      => 'name',
                'query_builder'      => function(EntityRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->orderBy('m.name', 'ASC');
                },
                'label'         => 'Measurement: ',
                'placeholder'   => 'Choose a Measurement',
                'required'      => false,
                'empty_data'    => null
            ))
            ->add('ingredient', new IngredientType(), array(
                'label' => false
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CookbookBundle\Entity\RecipeIngredient',
        ));
    }

    public function getName()
    {
        return 'recipeIngredient';
    }
}