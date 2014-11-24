<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 08.03.14
 * Time: 14:39
 */

namespace Stb\Bootstrap\Components;

class CallbackColumn extends ColumnAbstract {

    /**
     * @return string
     */
    public function getView()
    {
        return null;
    }

    /**
     * @param $column
     * @return string
     * @throws \Exception
     */
    public function createColumn($column){

        if(isset($column['name'])){
            $column['value'] = $this->propertyAccess->getValue($this->row, $column['name']);
        }
        if(!isset($column['callback']) && !$column['callback'] instanceof \Closure){
            throw new \Exception('Callback must be instance of \Closure');
        }
        return $column['callback']($column['value']);

    }
}