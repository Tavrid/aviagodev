<?php


namespace Acme\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CityType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                            ->add('id')
                            ->add('iata_code')
                            ->add('name_rus')
                            ->add('name_eng')
                            ->add('city_rus')
                            ->add('city_eng')
                            ->add('gmt_offset')
                            ->add('country_rus')
                            ->add('country_eng')
                            ->add('latitude')
                            ->add('longitude')
                        ;

    }

    public function getName() {
        return 'CityType';
    }

} 