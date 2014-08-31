<?php


namespace Acme\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GalleryType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name')
                ->add('description')
                ->add('is_show');

    }

    public function getName() {
        return 'GalleryType';
    }

} 