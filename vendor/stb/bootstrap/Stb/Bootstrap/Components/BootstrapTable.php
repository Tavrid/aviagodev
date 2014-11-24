<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11.03.14
 * Time: 16:53
 */

namespace Stb\Bootstrap\Components;
use Symfony\Component\DependencyInjection\ContainerInterface;


class BootstrapTable extends \Twig_Extension {

    /** @var \Symfony\Component\DependencyInjection\ContainerInterface*/

    protected $container;

    public function __construct(ContainerInterface $container){
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'bootstrapTable' => new \Twig_Function_Method($this, 'renderBootstrapTable')
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'bootstrap_bundle_list';
    }

    public function renderBootstrapTable($data,$params){

        $list = $this->getRows($data,$params);
        return $this->renderView('StbBootstrapBundle:List:list.html.twig', array(
            'list' => $list,
            'params' => $params
        ));
    }
    protected function renderView($view,$params){
        return $this->container->get('templating')->render($view, $params);
    }
    protected function getRows($data,$params,$index = 1){
        $list = '';
        $i = 0;
        foreach ($data as $value){
            $i ++;

            if(is_object($value)){
                if(method_exists($value,'getChildren') && $value->getChildren()){
                    $children = $value->getChildren();
                } else {
                    $children = array();
                }
            } else {
                if(isset($value['children']) && !empty($value['children'])){
                    $children = $value['children'];
                } else {
                    $children = array();
                }
            }

            if(count($children)){
                $d = new Row($this->container,$value,$params);
                $list.=$this->renderView('StbBootstrapBundle:List:row.html.twig',array('row' => $d->getRow($index,true)));
                $list.= $this->getRows($children,$params,($index + 1));
            } else {
                $d = new Row($this->container,$value,$params);
                $list.=$this->renderView('StbBootstrapBundle:List:row.html.twig',array('row' => $d->getRow($index,false)));
            }
        }
        return $list;
    }

} 