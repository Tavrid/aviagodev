<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 24.01.15
 * Time: 16:19
 */

namespace Acme\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AviaAirportsFilter extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('city_code', 'text', ['required' => false])
            ->add('airport_code', 'text', ['required' => false])
            ->add('city_name', 'text', ['required' => false])
            ->add('country_name', 'text', ['required' => false]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'avia_filter';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }


}