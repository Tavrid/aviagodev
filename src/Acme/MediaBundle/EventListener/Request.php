<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 7/5/13
 * Time: 8:22 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Acme\MediaBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class Request
{
    public function onKernelRequest(GetResponseEvent $event){
        $event->getRequest()->attributes->add();
    }
}