<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 08.01.14
 * Time: 13:08
 */

namespace Acme\AdminBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware {

    public function mainMenu(FactoryInterface $factory, array $options) {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $menu->addChild('menu', array('route' => 'admin.order.index', 'label' => 'Управление заказами'))
                ->setAttribute('icon', 'icon-align-center');
        $menu->addChild('airports', array('route' => 'admin.aviaairports.index', 'label' => 'Список аэропортов'))
                ->setAttribute('icon', 'icon-file');
        $menu->addChild('country', array('route' => 'admin.country.index', 'label' => 'Список стран'))
                ->setAttribute('icon', 'icon-file');

        return $menu;
    }

    public function stackedMenu(FactoryInterface $factory, array $options) {
        $menu = $factory->createItem('root');
//        $menu->setChildrenAttribute('class', 'nav nav-tabs nav-stacked');
//
//        $menu->addChild('page', array('route' => 'Page','label'=>'Текстовые страницы'))
//            ->setAttribute('icon','icon-align-center');
//        $menu->addChild('news', array('route' => 'Menu','label'=>'Управление новостями'))
//            ->setAttribute('icon','icon-rss');
//        $menu->addChild('news', array('route' => 'Menu','label'=>'Управление новостями'))
//            ->setAttribute('icon','icon-rss');

        return $menu;
    }

    public function userMenu(FactoryInterface $factory, array $options) {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');

        if ($this->container->get('security.context')->isGranted(array('ROLE_USER'))) {
            $username = $this->container->get('security.context')->getToken()->getUser()->getUsername();


            $menu->addChild('User', array('label' => 'Hi ' . $username))
                    ->setAttribute('dropdown', true)
                    ->setAttribute('icon', 'icon-user');

            $menu['User']->addChild('Change password', array('route' => 'fos_user_change_password'))
                    ->setAttribute('icon', 'icon-edit');
            $menu['User']->addChild('Выйти', array('route' => 'fos_user_security_logout'))
                    ->setAttribute('icon', 'icon-off');
        } // Check if the visitor has any authenticated roles

        return $menu;
    }

}
