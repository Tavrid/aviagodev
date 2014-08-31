<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 25.01.14
 * Time: 23:45
 */

namespace Acme\CoreBundle\DependencyInjection;

use Symfony\Component\Form\FormBuilderInterface;
class ListComponent extends GraphComponent {

    /**
     * @param FormBuilderInterface $builder
     * @return FormBuilderInterface
     */
    public function buildBaseFields(FormBuilderInterface $builder ){
        $choices = array();
        foreach ($this->getChildren() as $child){
            $choices[$child->getName()] = $child->getDescription();
        }
        $builder->add('tag','choice',array('label' => 'Тип страницы','choices' => $choices));
        $builder->add('name',null,array('label' => 'Заголовок'))
            ->add('uri',null,array('label' => 'Ссылка','required' => false));
        return $builder;
    }

} 