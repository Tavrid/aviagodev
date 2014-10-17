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
use Symfony\Component\Validator\Constraints as Assert;
use Bundles\ApiBundle\Api\Response\BookInfoResponse;
use Acme\CoreBundle\Model\AbstractModel;
use Bundles\DefaultBundle\Form\DataTransformer\PassengerTransformer;
use Acme\CoreBundle\Validator\DateRange;

class OrderForm extends AbstractType {

    /**
     * @var \Acme\AdminBundle\Model\Country
     */
    protected $countryModel;

    public function __construct(AbstractModel $countryModel) {
        $this->countryModel = $countryModel;
    }

    private function createTime($diffYear, $diffMonth = 0) {
        return mktime(date('H'), date('i'), date('s'), date('m') + $diffMonth, date('d'), date('Y') + $diffYear);
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        /* @var $bookInfoResponse BookInfoResponse */
        $bookInfoResponse = $options['bookInfoResponse'];
        $param = $bookInfoResponse->getEntity()->getTravelers();
        $this->bookInfoResponse = $bookInfoResponse;
        $fieldMap = array();
        $pattern = '/[\w\d]/';
        if ($bookInfoResponse->getEntity()->getTicket()->getLatinRegistration()) {
            $pattern = '/[a-zA-z0-9]/';
        }
        $fieldMap['ADT'] = ['sub_multi_field',
            'fields' => [
                'Sex' => ['field', new Assert\NotBlank()],
                'Name' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 2)), new Assert\Regex([
                        'pattern' => $pattern
                            ])],
                'Surname' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 2)), new Assert\Regex([
                        'pattern' => $pattern
                            ])],
                'Citizen' => ['field', new Assert\NotBlank()],
                'Document' => [
                    'Number' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 2))],
                    'ExpireDate' => ['field', new Assert\NotBlank(), new DateRange([
                            'min' => date('Y-m-d', $this->createTime(0, 1)),
                                ])],
//                    ]
                ],
                'Birthday' => ['field', new Assert\NotBlank(), new DateRange([
                        'max' => date('Y-m-d', $this->createTime(-12))
                            ])],
            ],
        ];
        $fieldMap['CHD'] = ['sub_multi_field',
            'fields' => [
                'Sex' => ['field', new Assert\NotBlank()],
                'Name' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 2)), new Assert\Regex([
                        'pattern' => $pattern
                            ])],
                'Surname' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 2)), new Assert\Regex([
                        'pattern' => $pattern
                            ])],
                'Citizen' => ['field', new Assert\NotBlank()],
                 'Document' => [
                    'Number' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 2))],
                    'ExpireDate' => ['field', new Assert\NotBlank(), new DateRange([
                            'min' => date('Y-m-d', $this->createTime(0, 1)),
                                ])],
//                    ]
                ],
                'Birthday' => ['field', new Assert\NotBlank(), new DateRange([
                        'max' => date('Y-m-d', $this->createTime(-2)),
                        'min' => date('Y-m-d', $this->createTime(-12)),
                            ])],
            ],
        ];
        $fieldMap['INF'] = ['sub_multi_field',
            'fields' => [
                'Sex' => ['field', new Assert\NotBlank()],
                'Name' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 2)), new Assert\Regex([
                        'pattern' => $pattern
                            ])],
                'Surname' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 2)), new Assert\Regex([
                        'pattern' => $pattern
                            ])],
                'Citizen' => ['field', new Assert\NotBlank()],
                 'Document' => [
                    'Number' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 2))],
                    'ExpireDate' => ['field', new Assert\NotBlank(), new DateRange([
                            'min' => date('Y-m-d', $this->createTime(0, 1)),
                                ])],
                ],
                'Birthday' => ['field', new Assert\NotBlank(), new DateRange([
                        'min' => date('Y-m-d', $this->createTime(-2)),
                        'max' => date('Y-m-d')
                            ])],
            ],
        ];
        $passengersParams = [
            'entity' => 'Acme\AdminBundle\Entity\Order',
            'field_map' => $fieldMap,
            'types' => [
                'ADT' => [
                    'options' => ['need_value' => $param['ADT']],
                    'Sex' => ['type' => 'choice', 'options' => [
                            'label' => 'frontend.order_form.passenger.gender',
                            'choices' => ['Male' => 'frontend.order_form.passenger.male', 'Female' => 'frontend.order_form.passenger.female'],
                            'multiple' => false,
                            'expanded' => true,
                        ]],
                    'Name' => ['options' => [
                            'label' => 'frontend.order_form.passenger.name',
                            'attr' => ['minlength' => 2],
                        ]],
                    'Surname' => ['options' => ['label' => 'frontend.order_form.passenger.surname']],
                    'Birthday' => [
                        'options' => [
                            'label' => 'frontend.order_form.passenger.birthday',
                            'attr' => [
                                'class' => 'birthday form-inline date-validator',
                                'maxdate' => date('d.m.Y', $this->createTime(-12))
                            ],
//                            'input' => 'array',
                            'widget' => 'single_text',
                            'format' => 'dd.M.yyyy',
                        ],
                        'type' => 'birthday'
                    ],
                    'Citizen' => [
                        'options' => [
                            'label' => 'frontend.order_form.passenger.citizen',
                            'choices' => $this->countryModel->getCountries(),
                            'data' => 'UA',
                            'attr' => ['class' => 'citizen', 'mask-input' => 'passport-mask-adt']
                        ],
                        'type' => 'choice'
                    ],
                    'Document' => [
                        'Number' => ['options' => [
                                'label' => 'frontend.order_form.passenger.number_passport',
                                'attr' => [
                                    'class' => 'passport-mask-adt',
                                ]
                            ]],
                        'ExpireDate' => [
                            'options' => [
                                'label' => 'frontend.order_form.passenger.passport_valid_until',
                                'attr' => [
                                    'class' => 'birthday form-inline date-validator',
                                    'mindate' => date('d.m.Y', $this->createTime(0, 1))
                                ],
//                                'input' => 'array',
                                'widget' => 'single_text',
                                'format' => 'dd.MM.yyyy',
                            ],
                            'type' => 'date'
                        ],
                    ],
                ],
                'CHD' => [
                    'options' => ['need_value' => $param['CHD']],
                    'Sex' => ['type' => 'choice', 'options' => [
                            'label' => 'frontend.order_form.passenger.gender',
                            'choices' => ['Male' => 'frontend.order_form.passenger.male', 'Female' => 'frontend.order_form.passenger.female'],
                            'multiple' => false,
                            'expanded' => true,
                        //                    'required' => true,
                        ]],
                    'Name' => ['options' => ['label' => 'frontend.order_form.passenger.name']],
                    'Surname' => ['options' => ['label' => 'frontend.order_form.passenger.surname']],
//                    'patronymic' => ['options' => ['label' => 'frontend.order_form.passenger.patronymic']],
                    'Birthday' => [
                        'options' => [
                            'label' => 'frontend.order_form.passenger.birthday',
                            'attr' => [
                                'class' => 'birthday form-inline child date-validator',
                                'maxdate' => date('d.m.Y', $this->createTime(-2)),
                                'mindate' => date('d.m.Y', $this->createTime(-12))
                            ],
//                            'input' => 'array',
                            'widget' => 'single_text',
                            'format' => 'dd.M.yyyy',
                        ],
                        'type' => 'birthday'
                    ],
                    'Citizen' => [
                        'options' => [
                            'label' => 'frontend.order_form.passenger.citizen',
                            'choices' => $this->countryModel->getCountries(),
                            'data' => 'UA',
                            'attr' => ['class' => 'citizen', 'mask-input' => 'passport-mask-adt']
                        ],
                        'type' => 'choice'
                    ],
                    'Document' => [
                        'Number' => ['options' => [
                                'label' => 'frontend.order_form.passenger.number_passport',
                                'attr' => [
                                    'class' => 'passport-mask-adt',
                                ]
                            ]],
                        'ExpireDate' => [
                            'options' => [
                                'label' => 'frontend.order_form.passenger.passport_valid_until',
                                'attr' => [
                                    'class' => 'birthday form-inline date-validator',
                                    'mindate' => date('d.m.Y', $this->createTime(0, 1))
                                ],
//                                'input' => 'array',
                                'widget' => 'single_text',
                                'format' => 'dd.MM.yyyy',
                            ],
                            'type' => 'date'
                        ],
                    ],
                ],
                'INF' => [
                    'options' => ['need_value' => $param['INF']],
                    'Sex' => ['type' => 'choice', 'options' => [
                            'label' => 'frontend.order_form.passenger.gender',
                            'choices' => ['Male' => 'frontend.order_form.passenger.male', 'Female' => 'frontend.order_form.passenger.female'],
                            'multiple' => false,
                            'expanded' => true,
                        //                    'required' => true,
                        ]],
                    'Name' => ['options' => ['label' => 'frontend.order_form.passenger.name']],
                    'Surname' => ['options' => ['label' => 'frontend.order_form.passenger.surname']],
//                    'patronymic' => ['options' => ['label' => 'frontend.order_form.passenger.patronymic']],
                    'Birthday' => [
                        'options' => [
                            'label' => 'frontend.order_form.passenger.birthday',
                            'attr' => [
                                'class' => 'birthday form-inline infant date-validator',
                                'mindate' => date('d.m.Y', $this->createTime(-2)),
                                'maxdate' => date('d.m.Y'),
                            ],
//                            'input' => 'array',
                            'widget' => 'single_text',
                            'format' => 'dd.M.yyyy',
                        ],
                        'type' => 'birthday'
                    ],
                    'Citizen' => [
                        'options' => [
                            'label' => 'frontend.order_form.passenger.citizen',
                            'choices' => $this->countryModel->getCountries(),
                            'data' => 'UA',
                            'attr' => ['class' => 'citizen', 'mask-input' => 'passport-mask-adt']
                        ],
                        'type' => 'choice'
                    ],
                    'Document' => [
                        'Number' => ['options' => [
                                'label' => 'frontend.order_form.passenger.number_passport',
                                'attr' => [
                                    'class' => 'passport-mask-adt',
                                ]
                            ]],
                        'ExpireDate' => [
                            'options' => [
                                'label' => 'frontend.order_form.passenger.passport_valid_until',
                                'attr' => [
                                    'class' => 'birthday form-inline date-validator',
                                    'mindate' => date('d.m.Y', $this->createTime(0, 1))
                                ],
//                                'input' => 'array',
                                'widget' => 'single_text',
                                'format' => 'dd.MM.yyyy',
                            ],
                            'type' => 'date'
                        ],
                    ],
                ]
            ]
        ];


        $builder->add('passengers', 'multi_field', $passengersParams)
                ->add('email', 'email', ['label' => 'frontend.order_form.email'])
                ->add('phone', 'text', ['label' => 'frontend.order_form.phone'])
                ->add('info', 'multi_field', [
                    'entity' => false,
                    'field_map' => [
                        'i_agree' => ['field', new Assert\NotBlank()]
                    ],
                    'types' => [
                        'i_agree' => [
                            'options' => ['label' => 'Ознакомлен(а) и согласен(-на)'],
                            'type' => 'checkbox'
                        ]
                    ]
        ]);
        $transformer = new PassengerTransformer();
        $builder->get('passengers')->addModelTransformer($transformer);
    }

    public function setDefaultOptions(\Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver) {
        $resolver->setRequired(['bookInfoResponse']);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        // TODO: Implement getName() method.
        return 'order';
    }

}
