<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 27.01.15
 * Time: 21:31
 */

namespace Acme\AdminBundle\Admin;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Knp\Menu\ItemInterface as MenuItemInterface;

class AirportsAdmin extends MainAdmin {

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('countryRus')
            ->add('cityRus')
            ->add('cityCodeEng')
            ->add('airportCodeEng')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('cityRus')
            ->add('countryRus')
            ->add('cityCodeEng')
            ->add('airportCodeEng')
            ->add('nameShortRu',null,['editable' => true,'label' => 'Короткое название(rus)'])
            ->add('nameShortEn',null,['editable' => true,'label' => 'Короткое название(en)'])
            ->add('nameShortUk',null,['editable' => true,'label' => 'Короткое название(uk)'])
        ;
    }

}