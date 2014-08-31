<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 7/5/13
 * Time: 11:08 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Acme\CoreBundle\Twig;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Awesome extends \Twig_Extension{

    protected $container;
    function __construct(ContainerInterface $container){
        $this->container = $container;
    }
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('getBoolIcon', array($this, 'getIcon')),
            new \Twig_SimpleFilter('createUrl', array($this, 'createUrl')),
            new \Twig_SimpleFilter('noJsScript', array($this, 'filterScript')),
            new \Twig_SimpleFilter('getTag', array($this, 'getTag')),
        );
    }

    /**
     * @return null | string
     */

    public function getTag($p){
        $request = $this->container->get('request');
        $tag = $request->get('_route');
        $tag = preg_replace('/_.+/i','',$tag);
        $tag = $this->container->get($tag);
        if(!$tag){
            return null;
        }
        return $tag->getName();

    }

    public function filterScript($string){
        return preg_replace('#<script(.*?)>(.*?)</script>#is','',$string);
    }

    public function getIcon($bool, $url = NULL, $mark = NULL, $token = NULL)
    {
        if(empty($bool)){
            $class = 'icon-minus-sign';
        } else {
            $class = 'icon-ok-sign';
        }
        if ($url){
            $class.=' alink_mark';
        }
        $val = $bool ? 0 : 1 ;
        return '<i class="'.$class.'" data-href="'.$url.'" mark="'.$mark.'" _token="'.$token.'" value="'.$val.'" title="Кликнуть для изменения" style="cursor: pointer"></i>';
    }

    public function createUrl($entity){
        $id  = $entity->getId();
        var_dump($entity);
        return 1;
    }

    public function getName()
    {
        return 'awesome_extension';
    }

}