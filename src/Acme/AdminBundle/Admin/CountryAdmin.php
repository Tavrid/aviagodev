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

class CountryAdmin extends Admin {

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('fullname')
            ->add('code')
            ->add('alpha2')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('passport_mask',null,['editable' => true,'label' => 'Маска для паспорта'])
            ->add('name')
            ->add('fullname')
            ->add('code')
            ->add('alpha2')
        ;
    }

}