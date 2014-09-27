<?php

namespace Acme\AdminBundle\Controller;

use Acme\AdminBundle\Entity\Order;
use Stb\Bootstrap\ColumnTypes;

use Symfony\Component\Form\AbstractType;
use Acme\AdminBundle\Form\Type\OrderType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Acme\AdminBundle\AcmeAdminBundleEvents as Events;
use Acme\AdminBundle\Event\ControllerEvent;
use Symfony\Component\Form\FormBuilder;

use Stb\Bootstrap\Response\EditableTextResponse;

class OrderController extends ControllerBase
{
    public function indexAction(){
        $data = $this->get('admin.order.manager')->findAllOrders();


        $controller = $this;
        return $this->render('AcmeAdminBundle:Order:index.html.twig', array(
            'data' => $data,
            'params' => array(
                'columns' => array(
                    'id',
                    [
                        'name' => 'stateName',
                        'header' => 'Статус',
                        'type' => ColumnTypes::TYPE_EDITABLE_TEXT,
                        'route' => ['admin.order.editstate',['id' => 'id']],
                        'form' => function(Order $order) use ($controller){
                            return $controller->createFormBuilder($order)
                                ->add('state','choice',['choices' => Order::$states])
                                ->getForm()->createView();

                        }
                    ],
                    [
                        'name' => 'date',
                        'header' => 'Дата',
                        'type' =>  ColumnTypes::TYPE_CALLBACK,
                        'callback' => function(\DateTime $dateTime){
                            return $dateTime->format('d M Y H:i:s');
                        }
                    ],
                    [
                        'name' => 'email',
                        'header' => 'Email'
                    ],
                    [
                        'name' => 'phone',
                        'header' => 'Телефон'
                    ],
                    [
                        'name' => 'price',
                        'header' => 'Цена'
                    ],
                    [
                        'name' => 'orderId',
                        'header' => 'Номер заказа'
                    ],


                ),
                'actions' => array(
                    'view' => array(
                        'route' => array('admin.order.show', array('id' => 'id')),
                        'type' => ColumnTypes::TYPE_LINK_IKON
                    ),
//                    'edit' => array(
//                        'route' => array('admin.order.edit', array('id' => 'id'))
//                    ),
                    'delete' => array(
                        'route' => array('admin.order.delete', array('id' => 'id'))
                    ),
                )
            )
        ));

    }

    public function showAction(Request $request){
        $orderManager = $this->get('admin.order.manager');
        $data = $orderManager->loadModel((int) $request->get('id'));
        if(!$data){
            throw $this->createNotFoundException('Error load data');
        }

        return $this->render('AcmeAdminBundle:Order:show.html.twig',['data' => $data]);
    }

//    public function editAction(Request $request)
//    {
//
//        $this->initBaseEvent(Events::INITIALIZE_EDIT, new OrderType());
//        return $this->edit($request);
//    }

    public function editStateAction(Request $request){
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
        $controller = $this;
        $dispatcher->addListener(Events::INITIALIZE_EDIT, function (ControllerEvent $event)  {


            $event->setDataManager($this->get('admin.order.manager'));

        });
        $dispatcher->addListener(Events::LOAD_ENTITY_EDIT,function(ControllerEvent $event) use ($controller){
            $form = $controller->createFormBuilder($event->getDataManager()->getEntity(), array('compound' => true))
                ->add('state','choice',['choices' => Order::$states])
                ->getForm();
            $event->setFrom($form);
        });

        $dispatcher->addListener(Events::ENTITY_SUCCESS_EDIT, function (ControllerEvent $event) {
            $form = $event->getForm();
            $data = $form->getData();
            $entity = $event->getDataManager()->getEntity();
            $renderedForm = $this->renderView(
                "AcmeAdminBundle:Order:_state_form.html.twig",
                array("form" => $form->createView())
            );
            $event->setResponse(new EditableTextResponse($renderedForm,$entity->getStateName()));
        });
        return $this->edit($request);
    }

//    public function addAction(Request $request)
//    {
//
//        $this->initBaseEvent(Events::INITIALIZE_ADD, new OrderType());
//        return $this->add($request);
//    }

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
