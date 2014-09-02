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
        $builder->add('city_from','text',['attr' => [
            'style' => 'width:198px;',
            'placeholder' => 'Введите город',
            'class' => 'inpWbtn faint_input']])
            ->add('city_to','text',['attr' => [
                'style' => 'width:198px;',
                'placeholder' => 'Введите город',
                'class' => 'inpWbtn faint_input']])
            ->add('date_from','text',['attr' => [
                'style' => 'width:198px; border:none;',
                'placeholder' => 'Укажите дату',
                'class' => 'inpWbtn']])
            ->add('date_to','text',['attr' => [
                'style' => 'width:198px; border:none;',
                'placeholder' => 'Укажите дату',
                'class' => 'inpWbtn']])
        ;

    }

    public function getName() {
        return 'SearchForm';
    }

} 