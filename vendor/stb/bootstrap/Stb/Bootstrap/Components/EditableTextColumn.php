<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 08.03.14
 * Time: 14:39
 */

namespace Stb\Bootstrap\Components;

class EditableTextColumn extends ColumnAbstract {

    /**
     * @return string
     */
    public function getView()
    {
        return 'StbBootstrapBundle:Columns:columnEditableText.html.twig';
    }

    public function createColumn($column)
    {

//        $column['form'] = null;
        if(isset($column['name'])){
            $column['value'] = $this->propertyAccess->getValue($this->row, $column['name']);
        }
        if(!isset($column['notify'])){
            $column['notify'] = 'Кликнуть для удаления';
        }

        if(isset($column['route'])){
            $column['url'] = $this->createRoute($column['route']);
        }
        $column['name'] = preg_replace('/[\]\[]/i','',$column['name']);

        $column['id'] = md5(microtime().uniqid());
        $column['form_id'] = "form-".$column['id'];
        if(empty($column['form'])){
            $form = $this->createFormBuilder();
            $form->add($column['name'],null,array('data' => $column['value']));
            $column['form'] = $form->getForm()->createView();
        } else if($column['form'] instanceof \Closure){
            $column['form'] = $column['form']($this->row);
        }


        $column['uniqid'] = md5(microtime());

        return $this->render($column);
    }


}