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

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $menu->addChild('menu', array('route' => 'admin.menu.index','label'=>'Управление меню'))
            ->setAttribute('icon','icon-align-center');
        $menu->addChild('news', array('route' => 'admin.page.index','label'=>'Список страниц'))
            ->setAttribute('icon','icon-file');
        $menu->addChild('slider', array('route' => 'admin.slider.index','label'=>'Список слайдеров'))
            ->setAttribute('icon','icon-desktop');
        $menu->addChild('gallery', array('route' => 'admin.gallery.index','label'=>'Список галерей'))
            ->setAttribute('icon','icon-picture');
        $menu->addChild('user', array('route' => 'admin.listuser.index','label'=>'Список пользователей'))
            ->setAttribute('icon','icon-picture');

//
//
//
        return $menu;
    }

    public function stackedMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav nav-tabs nav-stacked');

        $menu->addChild('page', array('route' => 'Page','label'=>'Текстовые страницы'))
            ->setAttribute('icon','icon-align-center');
        $menu->addChild('news', array('route' => 'Menu','label'=>'Управление новостями'))
            ->setAttribute('icon','icon-rss');
        $menu->addChild('news', array('route' => 'Menu','label'=>'Управление новостями'))
            ->setAttribute('icon','icon-rss');

        return $menu;
    }

    public function userMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');

        if($this->container->get('security.context')->isGranted(array('ROLE_USER'))) {
            $username = $this->container->get('security.context')->getToken()->getUser()->getUsername();


            $menu->addChild('User', array('label' => 'Hi '.$username))
                ->setAttribute('dropdown', true)
                ->setAttribute('icon', 'icon-user');

            $menu['User']->addChild('Change password', array('route'=>'fos_user_change_password'))
                ->setAttribute('icon', 'icon-edit');
            $menu['User']->addChild('Выйти', array('route'=>'fos_user_security_logout'))
                ->setAttribute('icon', 'icon-off');
        } // Check if the visitor has any authenticated roles

        return $menu;
    }
}