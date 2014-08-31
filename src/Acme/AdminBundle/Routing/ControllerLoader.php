<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 20.01.14
 * Time: 10:39
 */

namespace Acme\AdminBundle\Routing;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use \Symfony\Component\HttpKernel\Kernel;

class ControllerLoader implements LoaderInterface {

    private $loaded = false;
    protected $kernel;
    protected  $defaultBundle;

    public function __construct(Kernel $kernel,$defaultBundle = 'AcmeAdminBundle'){
        $this->kernel = $kernel;
        $this->defaultBundle = $defaultBundle;
    }

    public function load($resource, $type = null)
    {
        if (true === $this->loaded) {
            throw new \RuntimeException('Do not add the "extra" loader twice');
        }
        $routes = new RouteCollection();

        $this->_makeRoute($routes);

        $this->loaded = true;
        return $routes;
    }


    /**
     * @param RouteCollection $routes
     */

    protected function _makeRoute(RouteCollection &$routes){

        $kernel = $this->kernel;
        /** @var \Symfony\Component\HttpKernel\Bundle\Bundle $d */
        $d = $kernel->getBundle($this->defaultBundle);
        $r = new \ReflectionClass($d);
        $baseNameSpace = $r->getNamespaceName();
        $dirIterator = new \DirectoryIterator($d->getPath().'/Controller');
        /** @var \DirectoryIterator $dir */
        foreach($dirIterator as $dir){
            $controllerAndActions = $this->_getControllerAndActions($dir,$baseNameSpace);

            if(!empty($controllerAndActions)){
                foreach ($controllerAndActions as $controller => $actions){
                    foreach($actions as $action){
                        $fullControllerName = sprintf('%s:%s:%s',$this->defaultBundle,$controller,$action['name']);
                        $actionName = $this->_strFilteredToRoutePatch($action['name']);
                        if($actionName == 'index'){
                            $actionName = '';
                        } else {
                            $actionName='/'.$actionName;
                        }
                        $pattern = '/'.$this->_strFilteredToRoutePatch($controller).$actionName;
                        $routeName = RouteName::getRouteName($action['full_name']);
                        $defaults = array('_controller' => $fullControllerName);
                        $route = new Route($pattern, $defaults);
                        $routes->add($routeName, $route);
                    }
                }
            }
        }

    }

    protected function _strFilteredToRoutePatch($name){
        $str = str_replace('Controller','',$name);
        $str = preg_replace_callback('/([a-z])([A-Z])/',function($matches){
            return $matches[1].'-'.strtolower($matches[2]);
        },$str);
        return strtolower($str);
    }
    protected function _strFilteredToRouteName($controllerName){
        $str = str_replace('Controller','',$controllerName);

        return strtolower($str);
    }

    protected function _getControllerAndActions(\DirectoryIterator $dir,$baseNameSpace){
        $return = array();
        if(substr($dir->getFilename(),-14)=='Controller.php'){
            $controllerName = preg_replace('/Controller.php$/i','',$dir->getFilename());

            /** @var \SplFileInfo $fileInfo */
            $fileInfo = $dir->getFileInfo();
            $className = preg_replace('/\.php$/i','',$dir->getFilename());

            $r = new \ReflectionClass($baseNameSpace.'\Controller\\'.$className);
            /** @var \ReflectionMethod[] $methods */
            $methods = $r->getMethods();

            foreach($methods as $method){
                if(substr($method->name,-6)=='Action'){
                    $methodName = sprintf('%s::%s',$baseNameSpace.'\Controller\\'.$className,$method->name);
                    $return[$controllerName][] = array(
                        'name' => preg_replace('/Action$/i','',$method->name),
                        'full_name' => $methodName
                    );
                }
            }

        }
        return $return;
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