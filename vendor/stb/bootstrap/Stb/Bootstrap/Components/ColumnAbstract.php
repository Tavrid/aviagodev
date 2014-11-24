<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 08.03.14
 * Time: 14:34
 */

namespace Stb\Bootstrap\Components;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormBuilder;

abstract class ColumnAbstract {

    protected $params;

    /** @var \Symfony\Component\PropertyAccess\PropertyAccessor  */
    protected $propertyAccess;

    /** @var \Symfony\Component\DependencyInjection\ContainerInterface*/

    protected $container;

    protected $row;
    public function __construct(ContainerInterface $container){
        $this->container = $container;
        $this->propertyAccess = PropertyAccess::createPropertyAccessor();
    }

    public function setRow($row){
        $this->row = $row;
        return $this;
    }

    public function setParams($params){
        $this->params = $params;
        return $this;
    }

    /**
     * @param $column
     * @return string
     */
    public function createColumn($column){

        if(isset($column['name'])){
            $column['value'] = $this->propertyAccess->getValue($this->row, $column['name']);
        }
        if(isset($column['route'])){
            $column['url'] = $this->createRoute($column['route']);
        }



        return $this->render($column);
    }

    /**
     * @return string
     */
    public abstract function getView();

    public function render($parameters = array()){

        return $this->container->get('templating')->render($this->getView(), $parameters);
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

} 