<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 27.01.15
 * Time: 22:36
 */

namespace Acme\AdminBundle\Admin;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Knp\Menu\ItemInterface as MenuItemInterface;

class MainAdmin extends Admin {
    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {

    }


}