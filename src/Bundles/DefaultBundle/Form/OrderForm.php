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


use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;
use Bundles\ApiBundle\Api\Api;
use Bundles\ApiBundle\Api\Response\BookInfoResponse;
use Bundles\ApiBundle\Api\Query\BookQuery;
use Acme\CoreBundle\Model\AbstractModel;

use Bundles\DefaultBundle\Form\DataTransformer\PassengerTransformer;

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
    /**
     * @var \Acme\AdminBundle\Model\Country
     */
    protected $countryModel;
    public function __construct(BookInfoResponse $bookInfoResponse,Api $api,AbstractModel $countryModel){
        $this->countryModel = $countryModel;
        $param = $bookInfoResponse->getEntity()->getTravelers();
        $this->bookInfoResponse = $bookInfoResponse;
        $this->api = $api;
        $param = array_merge(array('ADT' => 1,'CHD' => 1,'INF' => 0),$param);
        $fieldMap = array();
        $pattern = '/[\w\d]/';
        if($bookInfoResponse->getEntity()->getTicket()->getLatinRegistration()){
            $pattern = '/[a-zA-z0-9]/';
        }
        $fieldMap['ADT'] = ['sub_multi_field',
            'fields' => [
                'Sex' => ['field', new Assert\NotBlank()],
                'Name' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3)),new Assert\Regex([
                    'pattern' => $pattern
                ])],
                'Surname' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3)),new Assert\Regex([
                    'pattern' => $pattern
                ])],

                'Citizen' => ['field', new Assert\NotBlank()],
                'Document' => [
                    'Number' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3))],
                    'ExpireDate' => ['field', new Assert\NotBlank()],
//                    ]
                ],
                'Birthday' => ['field', new Assert\NotBlank()],
            ],
        ];
        $fieldMap['CHD'] = ['sub_multi_field',
            'fields' => [
                'Sex' => ['field', new Assert\NotBlank()],
                'Name' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3)),new Assert\Regex([
                    'pattern' => $pattern
                ])],
                'Surname' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3)),new Assert\Regex([
                    'pattern' => $pattern
                ])],
                'Birthday' => ['field', new Assert\NotBlank()],

            ],
        ];
        $fieldMap['INF'] = ['sub_multi_field',
            'fields' => [
                'Sex' => ['field', new Assert\NotBlank()],
                'Name' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3)),new Assert\Regex([
                    'pattern' => $pattern
                ])],
                'Surname' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3)),new Assert\Regex([
                    'pattern' => $pattern
                ])],
                'Birthday' => ['field', new Assert\NotBlank()],
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
                    ]],
                    'Name' => ['options' => ['label' => 'frontend.order_form.passenger.name']],
                    'Surname' => ['options' => ['label' => 'frontend.order_form.passenger.surname']],
                    'Birthday' => [
                        'options' => [
                            'label' => 'frontend.order_form.passenger.birthday',
                            'attr' => ['class' => 'birthday form-inline'],
                            'years' => range(date('Y')-12,(date('Y') -99)),
                            'input' => 'array'
                        ],
                        'type' => 'birthday'
                    ],
                    'Citizen' => [
                        'options' => [
                            'label' => 'frontend.order_form.passenger.citizen',
                            'choices' => $this->countryModel->getCountries(),
                            'data' => 'UA'
                        ],
                        'type' => 'choice'
                    ],
                    'Document' => [
                        'Number' => ['options' => [
                            'label' => 'frontend.order_form.passenger.number_passport',
                            'attr' => ['class' => 'passport-mask']
                        ]],
                        'ExpireDate' => [
                            'options' => [
                                'label' => 'frontend.order_form.passenger.passport_valid_until',
                                'attr' => ['class' => 'birthday form-inline'],
                                'years' => range(date('Y'),date('Y')+10),
                                'input' => 'array'
                            ],
                            'type' => 'date'
                        ],
                    ],
                ],
                'CHD' => [
                    'options' => ['need_value' => $param['CHD']],
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
                ],
                'INF' => [
                    'options' => ['need_value' => $param['INF']],
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
        $transformer = new PassengerTransformer();
        $builder->get('passengers')->addModelTransformer($transformer);



        $bookInfoResponse = $this->bookInfoResponse;
        $api = $this->api;
        $builder->addEventListener(FormEvents::SUBMIT,function(FormEvent $event) use ($bookInfoResponse,$api){

            /** @var \Acme\AdminBundle\Entity\Order $data */
            $data = $event->getData();

            $query = new BookQuery();
            $travelers = $data->getPassengers();

            $query->setParams([
                'bookID' => $bookInfoResponse->getEntity()->getBookId(),
                'travellers' => $travelers,
                'contacts' => array(
                    'Email' => $data->getEmail(),
                    'PhoneMobile' => $data->getPhone(),
                    'PhoneHome' => ''
                ),
            ]);

            $output = $api->getBookRequestor()->execute($query);
            if($output->getIsError()){
                $m = '';
                foreach($output->getErrors() as $error){
                    $m.=$error['Data']['Message']."\n";//TODO потенциальная проблема при смене апи
                }
                $formError = new FormError($m);
                $event->getForm()->addError($formError);
            } else {
                $d = $output->getResponseData();
                $data->setPnr($d['result']['PNR'])//TODO потенциальная проблема при смене апи
                    ->setOrderInfo($d);
            }
        });

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