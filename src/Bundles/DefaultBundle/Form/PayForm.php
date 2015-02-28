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

class PayForm extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('pay_method', 'choice', [
            'expanded' => true,
            'choices' => $this->getPayMethods(),
            'label' => 'frontend.pay_form.pay_method'
        ]);
    }

    protected function getPayMethods()
    {
        return [
            "VISA_PRIVAT" => "Visa Приват",
            'GENERATE_CHECK' => 'сасостоятельная оплата чезер кассу банка'
        ];
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
        return 'pay_form';
    }

} 