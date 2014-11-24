<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 08.03.14
 * Time: 14:39
 */

namespace Stb\Bootstrap\Components;

class BoolEditableColumn extends ColumnAbstract {

    /**
     * @return string
     */
    public function getView()
    {
        return 'StbBootstrapBundle:Columns:columnBoolEditable.html.twig';
    }

    public function createColumn($column)
    {

        $column['value'] = $this->propertyAccess->getValue($this->row, $column['name']);

        if(!isset($column['notify'])){
            $column['notify'] = 'Кликнуть для изменения';
        }

        if(isset($column['route'])){
            $column['url'] = $this->createRoute($column['route']);
        }

        $column['id'] = md5(microtime().uniqid());
        $column['form_id'] = "form-".$column['id'];
        $column['form'] = $this->createFormBuilder()
            ->add('name', 'hidden',array('data' => $column['name']))
            ->getForm()->createView();
//        var_dump($column['form']->get('name')); exit;
        return $this->render($column);
    }


}