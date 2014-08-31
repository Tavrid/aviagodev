<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 27.03.14
 * Time: 15:02
 */

namespace Acme\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MenuType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', null, array('label' => 'Название'))
                ->add('isShow','checkbox',array('label' => 'Видимость','required' => false))
                ->add('page',null,array('label' => 'Страница'));

    }

    public function getName() {
        return 'Task';
    }

} 