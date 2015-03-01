<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 14.09.14
 * Time: 16:06
 */

namespace Bundles\DefaultBundle\Form;


use Acme\CoreBundle\Model\AbstractModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class PayForm extends AbstractType
{

    /**
     * @var \Acme\AdminBundle\Model\Country
     */
    protected $countryModel;

    public function __construct(AbstractModel $countryModel) {
        $this->countryModel = $countryModel;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $invoiceForm = $this->buildInvoiceFields($builder);

        $builder->add('pay_method', 'choice', [
            'expanded' => true,
            'choices' => $this->getPayMethods(),
            'label' => 'frontend.pay_form.pay_method'
        ])->add('invoice', 'checkbox', ['label' => 'frontend.pay_form.invoice', 'required' => false])
            ->add($invoiceForm);
    }

    /**
     * @param FormBuilderInterface $builder
     * @return FormBuilderInterface
     */
    protected function buildInvoiceFields(FormBuilderInterface $builder){
        $invoiceForm = $builder->create('invoice_data', null, ['compound' => true]);
        $invoiceForm->add('name','text',['label' => 'frontend.pay_form.invoice_field.name'])
            ->add('code','text',['label' => 'frontend.pay_form.invoice_field.code'])
            ->add('vat','text',['label' => 'frontend.pay_form.invoice_field.vat'])
            ->add('address','text',['label' => 'frontend.pay_form.invoice_field.address'])
            ->add('zip','text',['label' => 'frontend.pay_form.invoice_field.zip'])
            ->add('city','text',['label' => 'frontend.pay_form.invoice_field.city'])
            ->add('country','choice',['choices' => $this->countryModel->getCountries(),'label' => 'frontend.pay_form.invoice_field.country']);

        return $invoiceForm;
    }

    protected function getPayMethods()
    {
        return [
//            "VISA_PRIVAT" => "Visa Приват",
            'GENERATE_CHECK' => 'Сасостоятельная оплата чезер кассу банка'
        ];
    }


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'pay_form';
    }

} 