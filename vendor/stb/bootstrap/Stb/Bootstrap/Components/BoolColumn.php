<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 08.03.14
 * Time: 14:39
 */

namespace Stb\Bootstrap\Components;

class BoolColumn extends ColumnAbstract {

    /**
     * @return string
     */
    public function getView()
    {
        return 'StbBootstrapBundle:Columns:columnBool.html.twig';
    }

    public function createColumn($column)
    {

        $column['form'] = null;
        if(isset($column['name'])){
            $column['value'] = $this->propertyAccess->getValue($this->row, $column['name']);
        }
        if(!isset($column['notify'])){
            $column['notify'] = 'Кликнуть для удаления';
        }

        return $this->render($column);
    }


}