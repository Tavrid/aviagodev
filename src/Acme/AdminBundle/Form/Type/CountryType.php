<?php

namespace Acme\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CountryType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name')
                ->add('passport_mask')
                ->add('fullname')
                ->add('alpha2')
                ->add('alpha3')
        ;
    }

    public function getName() {
        return 'CountryType';
    }

}
