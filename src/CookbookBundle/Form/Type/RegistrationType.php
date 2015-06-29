<?php
/**
 * Created by PhpStorm.
 * User: Anna Kriener
 * Date: 27.05.2015
 * Time: 17:06
 */

namespace CookbookBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', new UserType(), array(
                'label' => false
            ))
            ->add('Register', 'submit');
    }

    public function getName()
    {
        return 'registration';
    }
}