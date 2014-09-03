<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 02.09.14
 * Time: 23:23
 */

namespace Bundles\DefaultBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('city_from','text',['attr' => ['placeholder' => 'Введите город']])
            ->add('city_to','text',['attr' => ['placeholder' => 'Введите город']])
            ->add('date_from','text',['attr' => ['placeholder' => 'Укажите дату']])
            ->add('date_to','text',['attr' => ['placeholder' => 'Укажите дату']]);

    }

    public function getName() {
        return 'SearchForm';
    }

} 