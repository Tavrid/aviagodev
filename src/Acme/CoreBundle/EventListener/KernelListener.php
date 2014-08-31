<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 20.01.14
 * Time: 10:12
 */

namespace Acme\CoreBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
//use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\DependencyInjection\ContainerInterface;
use \Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\Route;


class KernelListener {
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */

    protected $container;
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    private $router;

    function __construct(ContainerInterface $container,Router $router){
        $this->container = $container;
        $this->router = $router;

    }

    public function onKernelRequest(GetResponseEvent $event)
    {
//        $kernel    = $event->getKernel();
//        $request   = $event->getRequest();
//        $collection = $this->router->getRouteCollection();
//        $collection->add('blog_show', new Route('/graph/asd', array(
//            '_controller' => 'AcmeCoreBundle:Core:index',
//        )));
//
//
////        var_dump($this->router);exit;
////        var_Dump($this->container->get('core.graph.manager')->getArrayResult(array('tree' => 5)));exit;
//        var_Dump($request); exit;
////        $container = $this->container;
    }

} 