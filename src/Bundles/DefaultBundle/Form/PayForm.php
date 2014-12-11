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
            'choices' => $this->getPayMethods(),
            'label' => 'frontend.pay_form.pay_method'
        ]);
    }

    protected function getPayMethods()
    {
        return [
            "WEBMONEY_WALLET" => "Оплата с кошелька Webmoney",
            "WEBMONEY_CASH" => "Оплата наличными в терминале через Webmoney",
            "PRIVAT24" => "Оплата через интернет-банкинг Приват24",
            "PRIVATBANK" => "Оплата банковской картой ПриватБанка",
            "CCVISAMC" => "Оплата банковской картой, с вводом данных карты на странице PayU",
            "LIQPAY" => "Оплата с кошелька Liqpay",
            "LIQPAY_CARD" => "Оплата банковской картой, с вводом данных карты на странице Liqpay",
            "LIQPAY_TERMINAL" => "Оплата наличными, в любом банкомате ПриватБанка.",
            "CASH" => "Оплата наличными курьеру при доставке."
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