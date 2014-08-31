<?php

namespace Acme\AdminBundle\Controller;

use Stb\Bootstrap\ColumnTypes;

use Symfony\Component\Form\AbstractType;
use Acme\AdminBundle\Form\Type\PageType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Acme\AdminBundle\AcmeAdminBundleEvents as Events;
use Acme\AdminBundle\Event\ControllerEvent;

class ListUserController extends ControllerBase
{

    public function indexAction(Request $request)
    {
        /** @var \Acme\UserBundle\Model\UserManager $userManager */
        $userManager = $this->get('user.user_manager');
        $data = $userManager->findUsers();
        return $this->render('AcmeAdminBundle:ListUser:list.html.twig', array(
            'data' => $data,
            'params' => array(
                'columns' => array(
                    'id',
                    array('name' => 'usernameCanonical',
                        'header' => 'Заголовок'
                    ),
                    'emailCanonical',

                    array(
                        'name' => 'enabled',
                        'header' => 'Активный',
//                        'route' => array('admin.page.mark', array('id' => 'id')),
                        'type' => ColumnTypes::TYPE_BOOL
                    ),
                    array(
                       'name' =>'roles',
                        'type' => ColumnTypes::TYPE_CALLBACK,
                        'callback' => function($value){
                                return implode(', ',$value);
                            }
                    )
//                    'roles'


                ),
//                'actions' => array(
//                    'view' => array(
//                        'columns' => array(
//                            'id',
//                            array('name' => 'name'),
//                        )
//                    ),
//                    'edit' => array(
//                        'route' => array('admin.page.edit', array('id' => 'id'))
//                    ),
//                    'delete' => array(
//                        'route' => array('admin.page.delete', array('id' => 'id'))
//                    ),
//                )
            )
        ));
    }

}
