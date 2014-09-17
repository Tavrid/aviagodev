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


use Symfony\Component\Validator\Constraints as Assert;
use Acme\CoreBundle\Validator\Multifield;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class OrderForm  extends AbstractType{
    protected $passengersParams ;
    public function __construct($param){
        $param = array_merge(array('ADT' => 1,'CHD' => 1,'INF' => 0),$param);
        $fieldMap = array();

        $fieldMap['ADT'] = ['sub_multi_field',
            'fields' => [
                'gender' => ['field', new Assert\NotBlank()],
                'name' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3))],
                'surname' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3))],
                'patronymic' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3))],
                'number_passport' => ['field', new Assert\NotBlank()],
                'birthday' => ['field', new Assert\NotBlank(),new Assert\Date()],
                'passport_valid_until' => ['field', new Assert\NotBlank(),new Assert\Date()],
            ],
        ];
        $fieldMap['CHD'] = ['sub_multi_field',
            'fields' => [
                'gender' => ['field', new Assert\NotBlank()],
                'name' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3))],
                'surname' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3))],
                'patronymic' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3))],
                'birthday' => ['field', new Assert\NotBlank(),new Assert\Date()],

            ],
        ];
        $fieldMap['INF'] = ['sub_multi_field',
            'fields' => [
                'gender' => ['field', new Assert\NotBlank()],
                'name' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3))],
                'surname' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3))],
                'patronymic' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3))],
                'birthday' => ['field', new Assert\NotBlank(),new Assert\Date()],
            ],
        ];
        $this->passengersParams = [
            'entity'   => 'Acme\AdminBundle\Entity\Order',
            'field_map' => $fieldMap,
            'types' => [
                'ADT' => [
                    'options' => ['need_value' => $param['ADT']],
                    'gender' => ['type' => 'choice','options' => [
                        'label' => 'frontend.order_form.passenger.gender',
                        'choices' => ['m' => 'frontend.order_form.passenger.male','f' => 'frontend.order_form.passenger.female'],
                        'multiple' => false,
                        'expanded' => true,
    //                    'required' => true,
                    ]],
                    'name' => ['options' => ['label' => 'frontend.order_form.passenger.name']],
                    'surname' => ['options' => ['label' => 'frontend.order_form.passenger.surname']],
                    'patronymic' => ['options' => ['label' => 'frontend.order_form.passenger.patronymic']],
                    'number_passport' => ['options' => ['label' => 'frontend.order_form.passenger.number_passport']],
                    'birthday' => [
                        'options' => [
                            'label' => 'frontend.order_form.passenger.birthday',
                            'attr' => ['class' => 'birthday form-inline'],
                            'years' => range(date('Y')-12,(date('Y') -99)),
                            'input' => 'string'
                        ],
                        'type' => 'birthday'
                    ],
                    'passport_valid_until' => [
                        'options' => [
                            'label' => 'frontend.order_form.passenger.passport_valid_until',
                            'attr' => ['class' => 'birthday form-inline'],
                            'years' => range((date('Y') -2),date('Y')+10),
                            'input' => 'string'
                        ],
                        'type' => 'date'
                    ],
                ],
                'CHD' => [
                    'options' => ['need_value' => $param['CHD']],
                    'gender' => ['type' => 'choice','options' => [
                        'label' => 'frontend.order_form.passenger.gender',
                        'choices' => ['m' => 'frontend.order_form.passenger.male','f' => 'frontend.order_form.passenger.female'],
                        'multiple' => false,
                        'expanded' => true,
//                    'required' => true,
                    ]],
                    'name' => ['options' => ['label' => 'frontend.order_form.passenger.name']],
                    'surname' => ['options' => ['label' => 'frontend.order_form.passenger.surname']],
                    'patronymic' => ['options' => ['label' => 'frontend.order_form.passenger.patronymic']],
                    'birthday' => [
                        'options' => [
                            'label' => 'frontend.order_form.passenger.birthday',
                            'attr' => ['class' => 'birthday form-inline'],
                            'years' => range(date('Y')-4,(date('Y') -13)),
                            'input' => 'string'
                        ],
                        'type' => 'birthday'
                    ]
                ],
                'INF' => [
                    'options' => ['need_value' => $param['INF']],
                    'gender' => ['type' => 'choice','options' => [
                        'label' => 'frontend.order_form.passenger.gender',
                        'choices' => ['m' => 'frontend.order_form.passenger.male','f' => 'frontend.order_form.passenger.female'],
                        'multiple' => false,
                        'expanded' => true,
//                    'required' => true,
                    ]],
                    'name' => ['options' => ['label' => 'frontend.order_form.passenger.name']],
                    'surname' => ['options' => ['label' => 'frontend.order_form.passenger.surname']],
                    'patronymic' => ['options' => ['label' => 'frontend.order_form.passenger.patronymic']],
                    'birthday' => [
                        'options' => [
                            'label' => 'frontend.order_form.passenger.birthday',
                            'attr' => ['class' => 'birthday form-inline'],
                            'years' => range(date('Y'),(date('Y') -2)),
                            'input' => 'string'
                        ],
                        'type' => 'birthday'
                    ]
                ]
            ]
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('passengers','multi_field',$this->passengersParams)
        ->add('email','email',['label' => 'frontend.order_form.email'])
        ->add('phone','text',['label' => 'frontend.order_form.phone']);

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        // TODO: Implement getName() method.
        return 'order';
    }

} 