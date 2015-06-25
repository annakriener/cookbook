<?php
/**
 * Created by PhpStorm.
 * User: Anna Kriener
 * Date: 14.06.2015
 * Time: 16:35
 */

namespace CookbookBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\CallbackValidator;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class SearchRefineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
            ->add('title', 'text', array(
                'label' => 'Title',
                'attr' => array(
                    'placeholder' => 'spaghetti bolognese'
                ),
                'trim' => true,
                'required' => false
            ))
            ->add('category', 'entity', array(
                'class' => 'CookbookBundle:Category',
                'property' => 'name',
                'query_builder'      => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                'label' => 'Category: ',
                'placeholder' => 'Choose a category',
                'empty_data' => null,
                'required' => false
            ))
            ->add('ingredient1', 'text', array(
                'label' => "Include Ingredients",
                'attr' => array(
                    'placeholder' => "rice"
                ),
                'required' => false,
                'trim' => true,
            ))
            ->add('ingredient2', 'text', array(
                'label' => false,
                'attr' => array(
                    'placeholder' => "tomato"
                ),
                'required' => false,
                'trim' => true,
            ))
            ->add('ingredient3', 'text', array(
                'label' => false,
                'attr' => array(
                    'placeholder' => "chicken"
                ),
                'required' => false,
                'trim' => true,
            ))
            ->add('tag1', 'text', array(
                'label' => "Include Tags",
                'attr' => array(
                    'placeholder' => "easy"
                ),
                'required' => false,
                'trim' => true,
            ))
            ->add('tag2', 'text', array(
                'label' => false,
                'attr' => array(
                    'placeholder' => "spicy"
                ),
                'required' => false,
                'trim' => true,
            ))
            ->add('tag3', 'text', array(
                'label' => false,
                'attr' => array(
                    'placeholder' => false
                ),
                'required' => false,
                'trim' => true,
            ))
            ->add('dietary', 'entity', array(
                'class' => 'CookbookBundle:RecipeTag',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('rt')
                        ->leftJoin('rt.classification', 'c')
                        ->where('c.name = :classificationName')
                        ->setParameter('classificationName', 'dietary')
                        ->orderBy('rt.tag')
                        ->groupBy('rt.tag');
                },
                'property' => 'tag.name',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'empty_data' => null
            ))
            ->add('image', 'checkbox', array(
                'label' => 'with Photo',
                'required' => false,
                'trim' => true,
            ))
            ->add('submit', 'submit', array(
                'label' => "Filter"
            ));
    }

    public function getName()
    {
        return 'search_refine';
    }
}