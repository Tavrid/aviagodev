<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 20.01.14
 * Time: 10:39
 */

namespace Acme\CoreBundle\Routing;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\DependencyInjection\ContainerInterface;


class DbLoader implements LoaderInterface {

    private $loaded = false;
    protected $container;
    public function __construct(ContainerInterface $container){
        $this->container = $container;
    }

    public function load($resource, $type = null)
    {
        if (true === $this->loaded) {
            throw new \RuntimeException('Do not add the "extra" loader twice');
        }
        $graph = $this->container->get('graph.service');
        $routes = new RouteCollection();
        $this->_makeRoute($routes,$graph->getChildren(),'/content');
//        echo '<pre>';
//        var_dump($routes); exit;

        $this->loaded = true;
        return $routes;
    }

    /**
     * @param RouteCollection $routes
     * @param $tree \Acme\CoreBundle\DependencyInjection\GraphComponent[]
     * @param string $prefix
     */

    protected function _makeRoute(RouteCollection &$routes,$tree,$prefix=null){

        foreach ($tree as $val){
            // prepare a new route
            if(!$val->getChildren()){
                continue;
            }
            $pattern = $prefix.'/'.$val->getName();
            $this->_makeRoute($routes,$val->getChildren(),$pattern);

            $pattern = preg_replace('/[^\w\/\{\}]+/i','-',$prefix.'/'.$val->getName());
            $defaults = array('_controller' => 'AcmeCoreBundle:Content:index');
            $route = new Route($pattern, $defaults,array('id' => '\d+'));
            $routes->add($val->getName(), $route);

            $pattern = preg_replace('/[^\w\/\{\}]+/i','-',$prefix.'/'.$val->getName());
            $defaults = array('_controller' => 'AcmeCoreBundle:Content:index');
            $route = new Route($pattern.'/{id}', $defaults,array('id' => '\d+'));
            $routes->add($val->getName().'_parent', $route);



            $defaults = array('_controller' => 'AcmeCoreBundle:Content:new');
            $route = new Route($pattern.'/new', $defaults);
            $routeName = $val->getName().'_new';
            $routes->add($routeName, $route);

            $defaults = array( '_controller' => 'AcmeCoreBundle:Content:create');
            $route = new Route($pattern.'/create', $defaults);
            $routeName = $val->getName().'_create';
            $routes->add($routeName, $route);

            $defaults = array('_controller' => 'AcmeCoreBundle:Content:edit');
            $route = new Route($pattern.'/edit/{id}', $defaults);
            $routeName = $val->getName().'_edit';
            $routes->add($routeName, $route,array('id' => '\d+'));


            $defaults = array('_controller' => 'AcmeCoreBundle:Content:update',);
            $route = new Route($pattern.'/update/{id}', $defaults);
            $routeName = $val->getName().'_update';
            $routes->add($routeName, $route,array('id' => '\d+'));


            $defaults = array('_controller' => 'AcmeCoreBundle:Content:delete');
            $route = new Route($pattern.'/delete/{id}', $defaults);
            $routeName = $val->getName().'_delete';
            $routes->add($routeName, $route,array('id' => '\d+'));

            $defaults = array('_controller' => 'AcmeCoreBundle:Content:mark');
            $route = new Route($pattern.'/mark/{id}/{mark}', $defaults);
            $routeName = $val->getName().'_mark';
            $routes->add($routeName, $route,array_merge(array('id' => '\d+'),array('mark' => '\w+')));

        }

    }

    public function supports($resource, $type = null)
    {
        return 'extra' === $type;
    }

    public function getResolver()
    {
        // needed, but can be blank, unless you want to load other resources
        // and if you do, using the Loader base class is easier (see below)
    }

    public function setResolver(LoaderResolverInterface $resolver)
    {
        // same as above
    }

} 