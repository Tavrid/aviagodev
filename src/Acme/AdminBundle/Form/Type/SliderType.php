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

class SliderType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', null, array('label' => 'Название'))
                ->add('isShow','checkbox',array('label' => 'Видимость','required' => false))
                ->add('text',null,array('label' => 'Краткое описание'));

    }

    public function getName() {
        return 'Slider';
    }

} 