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

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;
use Bundles\ApiBundle\Api\Api;
use Bundles\ApiBundle\Api\Response\BookInfoResponse;
use Bundles\ApiBundle\Api\Query\BookQuery;

class OrderForm  extends AbstractType{
    /**
     * @var
     */
    protected $passengersParams;
    /**
     * @var Api
     */
    protected $api;
    /**
     * @var BookInfoResponse
     */
    protected $bookInfoResponse;
    public function __construct(BookInfoResponse $bookInfoResponse,Api $api){
        $param = $bookInfoResponse->getEntity()->getTravelers();
        $this->bookInfoResponse = $bookInfoResponse;
        $this->api = $api;
        $param = array_merge(array('ADT' => 1,'CHD' => 1,'INF' => 0),$param);
        $fieldMap = array();

        $fieldMap['ADT'] = ['sub_multi_field',
            'fields' => [
                'Sex' => ['field', new Assert\NotBlank()],
                'Name' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3))],
                'Surname' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3))],
//                'patronymic' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3))],
                'Document' => [
                    'Number' => ['field', new Assert\NotBlank()],
                    'ExpireDate' => ['field', new Assert\NotBlank(),new Assert\Date()],
//                    ]
                ],
                'Birthday' => ['field', new Assert\NotBlank(),new Assert\Date()],
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
                    'Sex' => ['type' => 'choice','options' => [
                        'label' => 'frontend.order_form.passenger.gender',
                        'choices' => ['Male' => 'frontend.order_form.passenger.male','Female' => 'frontend.order_form.passenger.female'],
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
                            'attr' => ['class' => 'birthday form-inline'],
                            'years' => range(date('Y')-12,(date('Y') -99)),
//                            'input' => 'string'
                        ],
                        'type' => 'birthday'
                    ],
                    'Document' => [
                        'Number' => ['options' => ['label' => 'frontend.order_form.passenger.number_passport']],
                        'ExpireDate' => [
                            'options' => [
                                'label' => 'frontend.order_form.passenger.passport_valid_until',
                                'attr' => ['class' => 'birthday form-inline'],
                                'years' => range((date('Y') -2),date('Y')+10),
                                'input' => 'string'
                            ],
                            'type' => 'date'
                        ],
                    ],
                ],
                'CHD' => [
                    'options' => ['need_value' => $param['CHD']],
                    'gender' => ['type' => 'choice','options' => [
                        'label' => 'frontend.order_form.passenger.gender',
                        'choices' => ['Male' => 'frontend.order_form.passenger.male','Female' => 'frontend.order_form.passenger.female'],
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
            ->add('phone','text',['label' => 'frontend.order_form.phone'])
            ->add('info','multi_field',[
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
        $bookInfoResponse = $this->bookInfoResponse;
        $api = $this->api;
        $builder->addEventListener(FormEvents::SUBMIT,function(FormEvent $event) use ($bookInfoResponse,$api){
            $data = $event->getData();
            $query = new BookQuery();
            $query->setParams([
                'bookID' => $bookInfoResponse->getEntity()->getBookId(),
                'travellers' => $data->getPassengers(),
                'contacts' => array(
                    'email' => 'ablylimov@gmail.com',
                    'PhoneMobile' => '+380669533156',
                    'PhoneHome' => ''
                ),
            ]);

            $output = $api->getBookInfoRequestor()->execute($query);
            $formError = new FormError('Error book');
            $event->getForm()->addError($formError);
        });

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