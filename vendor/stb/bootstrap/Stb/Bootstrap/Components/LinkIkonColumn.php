<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 08.03.14
 * Time: 14:39
 */

namespace Stb\Bootstrap\Components;

class LinkIkonColumn extends ColumnAbstract {

    /**
     * @return string
     */
    public function getView()
    {
        return 'StbBootstrapBundle:Columns:columnLinkIkon.html.twig';
    }

    public function createColumn($column)
    {

        if(!isset($column['notify'])){
            $column['notify'] = '';
        }

        if(isset($column['route'])){
            $column['url'] = $this->createRoute($column['route']);
        } else {
            $column['url'] = null;
        }
        if(!isset($column['icon'])){
            $column['icon'] = null;
        }
        return $this->render($column);
    }


}