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
                'name' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3))],
                'surname' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3))],
                'patronymic' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3))],
                'number_passport' => ['field', new Assert\NotBlank()],
                'birthday' => ['field', new Assert\NotBlank(),new Assert\DateTime()],
            ],
        ];
        $fieldMap['CHD'] = ['sub_multi_field',
            'fields' => [
                'name' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3))],
                'surname' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3))],
                'patronymic' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3))],
                'birthday' => ['field', new Assert\NotBlank(),new Assert\DateTime()],
            ],
        ];
        $fieldMap['INF'] = ['sub_multi_field',
            'fields' => [
                'name' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3))],
                'surname' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3))],
                'patronymic' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3))],
                'birthday' => ['field', new Assert\NotBlank(),new Assert\DateTime()],
            ],
        ];
        $this->passengersParams = [
            'entity'   => 'Acme\AdminBundle\Entity\Order',
            'field_map' => $fieldMap,
            'types' => ['ADT' => [
                'options' => ['need_value' => $param['ADT']],
                'name' => ['options' => ['label' => 'frontend.order_form.passenger.name']],
                'surname' => ['options' => ['label' => 'frontend.order_form.passenger.surname']],
                'patronymic' => ['options' => ['label' => 'frontend.order_form.passenger.patronymic']],
                'number_passport' => ['options' => ['label' => 'frontend.order_form.passenger.number_passport']],
                'birthday' => ['options' => ['label' => 'frontend.order_form.passenger.birthday']]
                ],
                'CHD' => [
                    'options' => ['need_value' => $param['CHD']],
                    'name' => ['options' => ['label' => 'frontend.order_form.passenger.name']],
                    'surname' => ['options' => ['label' => 'frontend.order_form.passenger.surname']],
                    'patronymic' => ['options' => ['label' => 'frontend.order_form.passenger.patronymic']],
                    'birthday' => ['options' => ['label' => 'frontend.order_form.passenger.birthday']]
                ],
                'INF' => [
                    'options' => ['need_value' => $param['INF']],
                    'name' => ['options' => ['label' => 'frontend.order_form.passenger.name']],
                    'surname' => ['options' => ['label' => 'frontend.order_form.passenger.surname']],
                    'patronymic' => ['options' => ['label' => 'frontend.order_form.passenger.patronymic']],
                    'birthday' => ['options' => ['label' => 'frontend.order_form.passenger.birthday']]
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