<?php

namespace Acme\CoreBundle\Form\Extension;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Validator\Constraint;

use Symfony\Component\Validator\MetadataFactoryInterface;
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
class Multifield extends AbstractType
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
            $options['field_map'] = $this->metadata
                ->getMetadataFor($options['entity'])
                ->properties[$builder->getName()]
                ->constraints[0]->fields;

        }



        foreach ($options['field_map'] as $field => $val) {

            if (in_array('field', $val)) {

                $constraints = array();
                foreach ($val as $c) {
                    if ($c instanceof Constraint) {
                        $constraints[] = $c;
                    }
                }
                $type = isset($options['types'][$field]['type']) ? $options['types'][$field]['type'] : null;
                if(isset($val['type'])){
                    $type = $val['type'];
                }
                $opt = array('constraints' => $constraints);
                if(isset($val['options'])){
                    $opt = array_merge($opt, $val['options']);
                }
                if (isset($options['types'][$field]['options'])) {
                    $opt = array_merge($opt, $options['types'][$field]['options']);
                }
                $builder->add($field, $type, $opt);
            } elseif (in_array('multi_field', $val)) {

                $constraints = array();
                foreach ($val as $c) {
                    if ($c instanceof Constraint) {
                        $constraints[] = $c;
                    }
                }
                $type = isset($options['types'][$field]['type']) ? $options['types'][$field]['type'] : null;
                if(isset($val['type'])){
                    $type = $val['type'];
                }
                $opt = array(
                    'type' => $type,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'prototype_name' => '__prototype__',
                    'constraints' => $constraints
                );
                if(isset($val['options'])){
                    $opt = array_merge($opt, $val['options']);
                }
                if (isset($options['types'][$field]['options'])) {
                    $opt = array_merge($opt, $options['types'][$field]['options']);
                }
                $builder->add($field, 'collection', $opt);
            } elseif (in_array('sub_multi_field', $val)) {

                $newOpt = array_merge($options,array(
                    'field_map'=>$val['fields'],
                    'types' => isset($options['types'][$field]) ? $options['types'][$field] : array()
                ));
                if(isset($val['options'])){
                    $newOpt = array_merge($newOpt, $val['options']);
                }
                if (isset($options['types'][$field]['options'])) {
                    $newOpt = array_merge($newOpt, $options['types'][$field]['options']);
                }

                $builder->add($field,'sub_multi_field',$newOpt);

            } else {
                $newOptions = array_merge($options, array(
                    'field_map' => $val,
                    'types' => isset($options['types'][$field]) ? $options['types'][$field] : array()));
                $builder->add($field, 'multi_field', $newOptions);
            }
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
        return 'multi_field';
    }

}