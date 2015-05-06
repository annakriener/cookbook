<?php

namespace CookbookBundle\Form\Type;

use CookbookBundle\Entity\Ingredient;
use CookbookBundle\Entity\RecipeIngredientReference;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecipeTagType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            /*
            ->add('tag', 'collection', array(
            'type' => new TagType(),
            'label' => 'Tag: ',
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false))
            */
            ->add('classification', 'entity', array(
                'class' => 'CookbookBundle:Classification',
                'property' => 'name',
                'label' => 'Classification: ',
                'placeholder' => 'Choose a Classification'
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'CookbookBundle\Entity\RecipeTagReference',
        ));
    }

    public function getName() {
        return 'recipeTag';
    }
}