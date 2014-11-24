<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 08.03.14
 * Time: 14:39
 */

namespace Stb\Bootstrap\Components;

class ModalIkonColumn extends ColumnAbstract {

    /**
     * @return string
     */
    public function getView()
    {
        return 'StbBootstrapBundle:Columns:columnModalIkon.html.twig';
    }

    public function createColumn($column)
    {

        if(isset($column['columns'])){
            foreach ($column['columns'] as $cl){
                if(is_string($cl)){
                    $cl = array('name' => $cl);
                }
                $column['data'][] = array(
                    'name' => isset($cl['header']) ? $cl['header'] : $cl['name'],
                    'value' => $this->propertyAccess->getValue($this->row,$cl['name'])
                );

            }
        } else {
            $column['data'] = array();
        }
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
        $column['id'] = md5(microtime().uniqid());

        return $this->render($column);
    }


}