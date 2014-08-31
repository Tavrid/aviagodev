<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 08.01.14
 * Time: 13:08
 */

namespace Bundles\DefaultBundle\Menu;


use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $menu->addChild('homepage', array('route' => 'bundles_default_homepage','label'=>'Home'));
        $menu->addChild('homepage2', array('route' => 'bundles_default_test','label'=>'Home2'));
        $menu->addChild('tean', array('route' => 'default.default.team.route','label'=>'Команда'));
        $menu->addChild('task', array('route' => 'default.task.route','label'=>'Задача'));



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

        if($this->container->get('security.context')->isGranted(array('ROLE_ADMIN'))) {
            $username = $this->container->get('security.context')->getToken()->getUser()->getUsername();


            $menu->addChild('User', array('label' => 'Hi '.$username))
                ->setAttribute('dropdown', true)
                ->setAttribute('icon', 'icon-user');

            $menu['User']->addChild('Profile', array('route'=>'fos_user_profile_show'))
                ->setAttribute('icon', 'icon-edit');
            $menu['User']->addChild('Выйти', array('route'=>'fos_user_security_logout'))
                ->setAttribute('icon', 'icon-off');
        } // Check if the visitor has any authenticated roles

        return $menu;
    }
}