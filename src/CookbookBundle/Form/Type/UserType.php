<?php
/**
 * Created by PhpStorm.
 * User: Anna Kriener
 * Date: 27.05.2015
 * Time: 16:54
 */

namespace CookbookBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array(
                'label' => 'Username:'
            ))
            ->add('email', 'email', array(
                'label' => 'Email:'
            ))
            ->add('password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'The password fields must match.',
                'first_options'  => array('label' => 'Password:'),
                'second_options' => array('label' => 'Repeat Password:'),
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CookbookBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'user';
    }
}