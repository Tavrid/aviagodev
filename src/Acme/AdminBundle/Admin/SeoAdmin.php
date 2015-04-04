<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 02.04.15
 * Time: 0:36
 */

namespace Acme\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Validator\ErrorElement;


class SeoAdmin extends MainAdmin {

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('prefix')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('prefix')
        ;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('prefix')
            ->add('cityFrom','sonata_type_model_autocomplete',[
                'property' => 'cityRus',
                'class' =>'Acme\AdminBundle\Entity\AviaAirports',
                'attr' => [
                    'style' => 'width:400px',
                ],
                'to_string_callback' => function($entity, $property) {
                    return sprintf('%d - %s (%s, %s)',$entity->getId(),$entity->getCityRus(),$entity->getCityCodeEng(),$entity->getAirportCodeEng());
                },
            ])
            ->add('cityTo','sonata_type_model_autocomplete',[
                'property' => 'cityRus',
                'class' =>'Acme\AdminBundle\Entity\AviaAirports',
                'attr' => [
                    'style' => 'width:400px',
                ],
                'to_string_callback' => function($entity, $property) {
                    return sprintf('%d - %s (%s, %s)',$entity->getId(),$entity->getCityRus(),$entity->getCityCodeEng(),$entity->getAirportCodeEng());
                },
            ])
            ->add('h1','html_editor',[
                'width' => 50
            ])
            ->add('template','html_editor');
    }



}