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
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', null, array('label' => 'Название'))
            ->add('isShow', 'checkbox', array('label' => 'Видимость','required' => false))
            ->add('text','multi_field',array('entity' => 'Acme\AdminBundle\Entity\Page'));

    }

    public function getName() {
        return 'Page';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\AdminBundle\Entity\Page',
        ));
    }

} 