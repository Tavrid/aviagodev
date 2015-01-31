<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 27.01.15
 * Time: 21:31
 */

namespace Acme\AdminBundle\Admin;
use Acme\AdminBundle\Entity\Order;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Knp\Menu\ItemInterface as MenuItemInterface;

class OrderAdmin extends MainAdmin {

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('state')
            ->add('phone')
            ->add('email')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('state','choice',['choices' => Order::$states,'editable' => true])
            ->add('phone')
            ->add('email')
            ->add('date')
            ->add('price')
            ->add('pnr')
            ->add('order_id')
        ;
    }

}