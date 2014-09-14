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
                'phone' => ['field', new Assert\NotBlank()],
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
//                'birthday' => ['type' => 'date']
                ],
                'CHD' => [
                    'options' => ['need_value' => $param['CHD']],
//                'birthday' => ['type' => 'date']
                ],
                'INF' => [
                    'options' => ['need_value' => $param['INF']],
//                'birthday' => ['type' => 'date']
                ]
            ]
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('passengers','multi_field',$this->passengersParams);
//        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            /** @var \Acme\AdminBundle\Entity\Order $data */
//            $data = $event->getData();
//            $data->setPassengers($_POST['order']['passengers']);
//            var_dump($data); exit;
//            $event->getForm()->setData($data);

//        });
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