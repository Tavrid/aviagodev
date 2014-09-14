<?php


namespace Acme\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class OrderType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                            ->add('id')
                            ->add('state')
                            ->add('date')
                            ->add('passengers')
                            ->add('info')
                        ;

    }

    public function getName() {
        return 'OrderType';
    }

} 