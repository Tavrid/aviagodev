<?php


namespace Acme\AdminBundle\Admin;


use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class TicketsAdmin extends MainAdmin
{
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('type')
            ->add('isEnabled', 'boolean', ['editable' => true])
            ->add('cityFrom','text')
            ->add('cityTo','text');
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->with('Активность')
                ->add('isEnabled','checkbox',['required' => false])
            ->end()
            ->with('Города(Аэропорты) билета')
                ->add('cityFrom', 'sonata_type_model_autocomplete', [
                    'required' => false,
                    'property' => 'cityRus',
                    'class' => 'Acme\AdminBundle\Entity\AviaAirports',
                    'attr' => [
                        'style' => 'width:400px',
                    ],
                    'to_string_callback' => function ($entity, $property) {
                        return sprintf('%d - %s (%s, %s)', $entity->getId(), $entity->getCityRus(), $entity->getCityCodeEng(), $entity->getAirportCodeEng());
                    },
                ])
                ->add('cityTo', 'sonata_type_model_autocomplete', [
                    'required' => false,
                    'property' => 'cityRus',
                    'class' => 'Acme\AdminBundle\Entity\AviaAirports',
                    'attr' => [
                        'style' => 'width:400px',
                    ],
                    'to_string_callback' => function ($entity, $property) {
                        return sprintf('%d - %s (%s, %s)', $entity->getId(), $entity->getCityRus(), $entity->getCityCodeEng(), $entity->getAirportCodeEng());
                    },
                ])
            ->end();
    }


}