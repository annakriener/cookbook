<?php

namespace CookbookBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClassificationType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', 'text', array('label' => 'Classification: ', 'trim' => true))
                ->add('save', 'submit', array('label' => 'Create Classification'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'CookbookBundle\Entity\Classification',
        ));
    }

    public function getName() {
        return 'classification';
    }
}