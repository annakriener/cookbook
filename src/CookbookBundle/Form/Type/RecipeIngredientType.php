<?php

namespace CookbookBundle\Form\Type;

use CookbookBundle\Entity\Ingredient;
use CookbookBundle\Entity\RecipeIngredientReference;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecipeIngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', 'text', array('label' => 'Quantity:'))
            ->add('measurement', 'entity', array(
                'class' => 'CookbookBundle:Measurement',
                'property' => 'name',
                'label' => 'Measurement: ',
                'placeholder' => 'Choose a Measurement',
                'empty_data' => 'null'
            ))
            ->add('ingredient', new IngredientType());
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