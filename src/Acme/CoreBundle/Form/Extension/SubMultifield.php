<?php

namespace Acme\CoreBundle\Form\Extension;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Validator\MetadataFactoryInterface;

use Symfony\Component\PropertyAccess\PropertyAccess;

/*
 *
 * add to you entity class
 *
 * public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
        $metadata->addPropertyConstraint('text', new Multifield(array(
            'fields' => array(
                'foo' => array('field',new Assert\NotBlank(), new Assert\Length(array('min' => 10))),
                'm' =>array('sub_multi_field','fields' =>
                    ['d' => array('field',new Assert\NotBlank(), new Assert\Length(array('min' => 10)))]
                )
            )
        )));

    }
 *
 *
 *
 */
class SubMultifield extends AbstractType
{
    /**
     * @var \Symfony\Component\Validator\MetadataFactoryInterface
     */
    protected $metadata;


    function __construct(MetadataFactoryInterface $metadata)
    {
        $this->metadata =$metadata;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (empty($options['field_map'])) {
            $fields = $this->metadata
                ->getMetadataFor($options['entity'])
                ->properties[$builder->getName()]
                ->constraints[0]->fields;

            $options['field_map'] = $fields;
        }


        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($options) {
            $data = $event->getData();

            if(!empty($data)){
                $newData = array();
                $i = 1;
                foreach($data as $val){
                    $newData[$i++] = $val;
                }
                $data = $newData;
            }
            $form = $event->getForm();


//            foreach($form as $child){
//                $form->remove($child->getName());
//            }

            if(!empty($data)){

                foreach($data as $field => $val){
                    $form->add($field, 'multi_field',$options);
                }
            } else if($options['need_value']) {
                $form->add(1, 'multi_field',$options);
            }


        });

        $a = $builder->create('__prototype__', 'multi_field',$options);

        $builder->setAttribute('prototype', $a->getForm());
        $builder->setAttribute('sub_multi_field', true);
    }




    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if ($form->getConfig()->hasAttribute('sub_multi_field')) {
            $view->vars['sub_multi_field'] = $form->getConfig()->getAttribute('sub_multi_field');
        }
        if ($form->getConfig()->hasAttribute('prototype')) {
            $view->vars['prototype'] = $form->getConfig()->getAttribute('prototype')->createView($view);

        }
    }



    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

        $resolver->setDefaults(array(
            'compound' => true,
            'prototype' => true,
            'field_map' => array(),
            'resolved_data' => false,
            'types' => array(),
            'need_fields' => array(),
            'without_fields' => array(),
            'need_value' => false
        ));
        $resolver->setRequired(array('entity'));
    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'sub_multi_field';
    }

}