<?php

namespace Acme\AdminBundle\Controller;

use Acme\BootstrapBundle\ColumnTypes;

use Symfony\Component\Form\AbstractType;
use Acme\AdminBundle\Form\Type\OrderType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Acme\AdminBundle\AcmeAdminBundleEvents as Events;
use Acme\AdminBundle\Event\ControllerEvent;
/*
 You will need add to your configuration
    file: You bundle directory/Resources/config/services.yml

    admin.order.manager :
          class: Acme\AdminBundle\Model\Order
          arguments:
              - "@service_container"
              - Acme\AdminBundle\Entity\Order
    */

class OrderController extends ControllerBase
{
    public function indexAction(){
        return new Response('You need edit this action');
    }

    public function editAction(Request $request)
    {

        $this->initBaseEvent(Events::INITIALIZE_EDIT, new OrderType());
        return $this->edit($request);
    }

    public function addAction(Request $request)
    {

        $this->initBaseEvent(Events::INITIALIZE_ADD, new OrderType());
        return $this->add($request);
    }

    public function deleteAction(Request $request)
    {

        $this->initBaseEvent(Events::INITIALIZE_DELETE);
        return $this->delete($request);
    }




    protected function initBaseEvent($eventName, AbstractType $formType = null)
    {
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
        $dispatcher->addListener($eventName, function (ControllerEvent $event) use ($formType) {
            $event->setDataManager($this->get('admin.order.manager'))
;
            if ($formType) {
                $event->setFormType($formType);
            }
        });
    }

}
