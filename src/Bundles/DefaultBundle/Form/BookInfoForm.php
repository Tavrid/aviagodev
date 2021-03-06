<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 14.09.14
 * Time: 16:06
 */

namespace Bundles\DefaultBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class BookInfoForm  extends AbstractType{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('variants','collection',[
            'type'   => 'text',
            'allow_add' => true,
            'mapped' => false,
        ])
        ->add('request_id','hidden');
        $builder->addEventListener(FormEvents::PRE_SUBMIT,function(FormEvent $event){
            $form = $event->getForm();
            $data = $event->getData();
            $form->setData($data);
        });
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        // TODO: Implement getName() method.
        return 'info';
    }

} 