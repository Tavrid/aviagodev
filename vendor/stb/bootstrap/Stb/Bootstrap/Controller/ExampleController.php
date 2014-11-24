<?php

namespace Stb\BootstrapBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Stb\Bootstrap\ColumnTypes;



class ExampleController extends Controller
{
    public function indexAction(Request $request)
    {
        list($entities, $pagerHtml) = $this->get('core.graph.manager')
            ->paginator($request->get('page', 1),array('createBaseTree' => array(3,false)),'admin_view',20);

        return $this->render('StbBootstrapBundle:Example:list.html.twig',array(
            'data' =>$entities,
            'params'=>array(
                'pagerHtml' => $pagerHtml,
                'columns'  => [
                    array('name' => 'name'),
                    'id',
                    array('name' => 'uri','header' => 'Ссылка','route' => array('bootstrap_edit',array('id' => 'id')),'type' => ColumnTypes::TYPE_EDITABLE_TEXT),
                    'tag',
                    array(
                        'name' => 'show',
                        'type' => ColumnTypes::TYPE_BOOL_EDITABLE,
                        'route' => array('bootstrap_edit',array('id' => 'id'))

                    )
                ],
//                'editableFields' => array(
//                    'show' => array(
//                        'type' => EditableTypes::TYPE_BOOL,
//                        'route' => array('bootstrap_edit',array('id' => '[id]'))
//                    )
//                ),
                'actions' => array(
                    'view' => array(
                        'columns' => array(
                            'id',
                            array('name' => 'name'),
                            array('name' => 'uri','header' => 'Ссылка'),
                            'tag',
                            array('name' => 'show','header' => 'Отображать')
                        )
                    ),
                    'edit' => array(
                        'route' => array('bootstrap_edit',array('id' => 'id'))
                    ),
                    'delete' => array(
                        'route' => array('bootstrap_delete',array('id' => 'id'))
                    ),
                )
            )
        ));
    }




}
