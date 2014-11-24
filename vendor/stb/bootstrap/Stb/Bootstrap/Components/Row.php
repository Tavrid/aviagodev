<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 06.03.14
 * Time: 17:22
 */


namespace Stb\Bootstrap\Components;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormBuilder;
use Stb\Bootstrap\ColumnTypes;

class Row {

    protected $row;

    protected $params;

    /** @var \Symfony\Component\PropertyAccess\PropertyAccessor  */
    protected $propertyAccess;


    protected $actionsMap = array(
        'view' => array(
            'icon' => 'fa fa-eye',
            'type' => ColumnTypes::TYPE_MODAL_IKON,
            'notify' => 'Просмотреть',
        ),
        'edit' => array(
            'icon' => 'fa fa-pencil',
            'type' => ColumnTypes::TYPE_LINK_IKON,
            'notify' => 'Редактировать'
        ),
        'delete' => array(
            'icon' => 'fa fa-trash-o',
            'type' => ColumnTypes::TYPE_AJAX_IKON,
            'notify' => 'Удалить',
            'confirm' => 'Удалить запись?'
        ),
    );
    /** @var \Symfony\Component\DependencyInjection\ContainerInterface*/
    protected $container;


    public function __construct(ContainerInterface $container,$row,$params){
        $this->row = $row;
        $this->params = $params;
        $this->container = $container;
        $this->propertyAccess = PropertyAccess::createPropertyAccessor();
    }

    /**
     * Creates and returns a form builder instance
     *
     * @param mixed $data    The initial data for the form
     * @param array $options Options for the form
     *
     * @return FormBuilder
     */
    public function createFormBuilder($data = null, array $options = array())
    {
        return $this->container->get('form.factory')->createBuilder('form', $data, $options);
    }

    public function getRow($index = 0,$hasChild = false){

        $data = array(
            'index' => $index,
            'hasChild' => $hasChild
        );

        foreach($this->params['columns'] as $column){
            $data['columns'][] = $this->creteColumn($column);
        }


        if(isset($this->params['actions'])){
//            $this->params['actions']  = array_replace_recursive($this->actionsMap,$this->params['actions']);

            foreach($this->params['actions'] as $n => $action){
                if(isset($this->actionsMap[$n])){
                    $action = array_replace_recursive($this->actionsMap[$n],$action);
                }
                $data['actions'][$n] = $this->creteColumn($action);
            }
        }

        return $data;
    }


    protected function creteColumn($column){

        if(is_string($column)){
            $column = array('name' => $column);
        }
        if(!isset($column['type'])){
            $column['type'] = ColumnTypes::TYPE_BASE;
        }
        /** @var ColumnAbstract $columnCreator */
        $columnCreator =  $this->container->get($column['type']);
        return $columnCreator->setRow($this->row)
                ->setParams($this->params)
                ->createColumn($column);
    }


    protected function createRoute($data){
        $routeName = $data[0];
        unset($data[0]);
        $routeParams = array();
        foreach ( $data as $k => $v){
            if(is_array($v)){
                foreach ( $v as $key => $val){
                    $routeParams[$key]  = $this->propertyAccess->getValue($this->row, $val);
                }
            } else {
                $routeParams[$k] = $v;
            }
        }
        return $this->container->get('router')->generate($routeName, $routeParams);
    }

} 