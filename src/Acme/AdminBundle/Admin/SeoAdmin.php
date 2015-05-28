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
            ->add('prefix','text',['editable' => true])
            ->add('cityFrom')
            ->add('cityTo')
        ;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form->tab('Основная информация')
                ->with(null)
                    ->add('prefix')
                    ->add('cityFrom','sonata_type_model_autocomplete',[
                        'required' => false,
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
                        'required' => false,
                        'property' => 'cityRus',
                        'class' =>'Acme\AdminBundle\Entity\AviaAirports',
                        'attr' => [
                            'style' => 'width:400px',
                        ],
                        'to_string_callback' => function($entity, $property) {
                            return sprintf('%d - %s (%s, %s)',$entity->getId(),$entity->getCityRus(),$entity->getCityCodeEng(),$entity->getAirportCodeEng());
                        },
                    ])
                ->end()
                ->with('Шаблоны автогенирации')
                    ->add('h1','html_editor',[
                        'width' => 50
                    ])
                    ->add('template','html_editor')
                ->end()
            ->end()
            ->tab('Мета тэги')
                ->with(null)
                    ->add('metaTags','multi_field',[
                        'label' => 'Мета тэги',
                        'entity' => 'Acme\AdminBundle\Entity\Seo',
                        'field_map' => [
                            'title' => ['field'],
                            'description' => ['field'],
                            'keywords' => ['field'],
                        ],
                        'types' => [
                            'title' => ['type'=>'html_editor','options' => ['width' => 100]],
                            'description' => ['type'=>'html_editor','options' => ['width' => 150]],
                            'keywords' => ['type'=>'html_editor','options' => ['width' => 150]],
                        ]
                    ])
                ->end()
            ->end();
    }



}