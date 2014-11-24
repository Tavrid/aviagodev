<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 08.03.14
 * Time: 14:39
 */

namespace Stb\Bootstrap\Components;

class AjaxIkonColumn extends ColumnAbstract {

    /**
     * @return string
     */
    public function getView()
    {
        return 'StbBootstrapBundle:Columns:columnAjaxIkon.html.twig';
    }

    public function createColumn($column)
    {

        if(!isset($column['notify'])){
            $column['notify'] = '';
        }
        if(!isset($column['confirm'])){
            $column['confirm'] = null;
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
        $column['form_id'] = "form-".$column['id'];
        $column['form'] = $this->createFormBuilder()
            ->getForm()->createView();
        return $this->render($column);
    }


}