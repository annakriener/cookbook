<?php
/**
 * Created by PhpStorm.
 * User: Anna Kriener
 * Date: 04.05.2015
 * Time: 15:51
 */

namespace CookbookBundle\Form\Type;


use CookbookBundle\Entity\Ingredient;
use CookbookBundle\Entity\RecipeIngredientReference;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecipeType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', 'text', array('label' => 'Title: '))
            ->add('author', 'text', array('label' => 'Author: '))
            ->add('source', 'text', array('label' => 'Source: '))
            ->add('duration', 'time', array('label' => 'Duration: '))
            ->add('category', 'entity', array(
                'class' => 'CookbookBundle:Category',
                'property' => 'name',
                'label' => 'Category: ',
                'placeholder' => 'Choose a category',
                'empty_data' => 'null'
            ))

            ->add('recipe_tag_references', 'collection', array(
                'type' => new RecipeTagType(),
                'label' => 'Tags: ',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false))

             ->add('recipe_ingredient_references', 'collection', array(
                'type' => new RecipeIngredientType(),
                'label' => 'Ingredients: ',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false))

            ->add('servings', 'integer', array('label' => 'Yields: '))
            ->add('preparation', 'textarea', array('label' => 'Preparation: '))
            ->add('instruction', 'textarea', array('label' => 'Instruction: '))
            ->add('image', 'text', array('label' => 'Image: '))
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