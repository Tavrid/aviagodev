<?php

namespace Acme\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AviaairportsType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
//                            ->add('id')
                ->add('favorite')
                ->add('iataRegionCode')
                ->add('iataTcCode')
                ->add('regionCode')
                ->add('regionCodeRus')
                ->add('regionEng')
                ->add('regionRus')
                ->add('countryCode')
                ->add('countryCodeRus')
                ->add('countryEng')
                ->add('countryRus')
                ->add('stateCode')
                ->add('stateCodeRus')
                ->add('stateEng')
                ->add('stateRus')
                ->add('cityCodeEng')
                ->add('cityCodeRus')
                ->add('cityEng')
                ->add('cityRus')
                ->add('cityLat')
                ->add('cityLng')
                ->add('cityTimezone')
                ->add('airportCodeEng')
                ->add('airportCodeRus')
                ->add('airportEng')
                ->add('airportRus')
                ->add('airportLat')
                ->add('airportLng')
                ->add('timezone')
        ;
    }

    public function getName() {
        return 'AviaairportsType';
    }

}
