<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 08.03.14
 * Time: 14:39
 */

namespace Stb\Bootstrap\Components;

class IconColumn extends ColumnAbstract {

    /**
     * @return string
     */
    public function getView()
    {
        return 'StbBootstrapBundle:Columns:columnIcon.html.twig';
    }
    public function createColumn($column)
    {

        if(!isset($column['icon'])){
            $column['icon'] = null;
        }
        if(!isset($column['class'])){
            $column['class'] = null;
        }

        return $this->render($column);
    }

}