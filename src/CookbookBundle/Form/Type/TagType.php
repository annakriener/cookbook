<?php

namespace CookbookBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TagType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', 'text', array('label' => 'Tag: ', 'trim' => true));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'CookbookBundle\Entity\Tag',
        ));
    }

    public function getName() {
        return 'tag';
    }
}