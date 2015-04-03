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
            ->add('h1')
            ->add('template');
    }


}