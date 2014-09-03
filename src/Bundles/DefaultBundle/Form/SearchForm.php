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
        $adults = array();
        for ($i = 1; $i < 10; $i ++){
            $adults[$i] = $i;
        }
        $children = array();
        for ($i = 1; $i < 10; $i ++){
            $children[$i] = $i;
        }
        $builder->add('city_from','text',['attr' => ['placeholder' => 'Введите город']])
            ->add('city_to','text',['attr' => ['placeholder' => 'Введите город']])
            ->add('date_from','text',['attr' => ['placeholder' => 'Укажите дату']])
            ->add('date_to','text',['attr' => ['placeholder' => 'Укажите дату']])
            ->add('adults','choice',['choices' => $adults])
            ->add('children','choice',['choices' => $children])
            ->add('class','choice',['choices' => []])
            ->add('avia_company','choice',['choices' => []])
            ->add('currency','choice',['choices' => []])
            ->add('best_price','checkbox',['required' => false])
            ->add('direct_flights','checkbox',['required' => false])

        ;

    }

    public function getName() {
        return 'SearchForm';
    }

} 