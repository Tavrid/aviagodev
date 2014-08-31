<?php

namespace Acme\AdminBundle\Controller;

use Stb\Bootstrap\ColumnTypes;

use Symfony\Component\Form\AbstractType;
use Acme\AdminBundle\Form\Type\PageType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Acme\AdminBundle\AcmeAdminBundleEvents as Events;
use Acme\AdminBundle\Event\ControllerEvent;

use Stb\Bootstrap\Response\EditableTextResponse;

class PageController extends ControllerBase
{

    public function indexAction(Request $request)
    {

        $data = $this->get('admin.page.manager')->findAll();
//        var_dump($data); exit;
        return $this->render('AcmeAdminBundle:Page:list.html.twig', array(
            'data' => $data,
            'params' => array(
                'columns' => array(
                    'id',
                    array(
                        'name' => 'name',
                        'header' => 'Заголовок',
                        'route' => array('admin.page.editname',array('id' => 'id')),'type' => ColumnTypes::TYPE_EDITABLE_TEXT),
                    array(
                        'name' => 'isShow',
                        'header' => 'Видимый',
                        'route' => array('admin.page.mark', array('id' => 'id')),
                        'type' => ColumnTypes::TYPE_BOOL_EDITABLE
                    )

                ),
                'actions' => array(
                    'view' => array(
                        'columns' => array(
                            'id',
                            array('name' => 'name'),
                        )
                    ),
                    'edit' => array(
                        'route' => array('admin.page.edit', array('id' => 'id'))
                    ),
                    'delete' => array(
                        'route' => array('admin.page.delete', array('id' => 'id'))
                    ),
                )
            )
        ));
    }

    public function editNameAction(Request $request){
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
        $controller = $this;
        $dispatcher->addListener(Events::INITIALIZE_EDIT, function (ControllerEvent $event) use ($controller) {

            $form = $controller->createFormBuilder(null, array('compound' => true))
                ->add('name')
                ->getForm();
            $event->setDataManager($this->get('admin.page.manager'))
//                ->setUploaderManager($this->get('admin.page.uploader'))
                ->setFrom($form);

        });

        $dispatcher->addListener(Events::ENTITY_SUCCESS_EDIT, function (ControllerEvent $event) {
            $form = $event->getForm();
            $data = $form->getData();

            $renderedForm = $this->renderView(
                "AcmeAdminBundle:Page:name_form.html.twig",
                array("form" => $form->createView())
            );
            $event->setResponse(new EditableTextResponse($renderedForm,$data['name']),
                $data['name']);
        });
        return $this->edit($request);
    }

    public function editAction(Request $request)
    {

        $this->initBaseEvent(Events::INITIALIZE_EDIT, new PageType());
        return $this->edit($request);
    }

    public function addAction(Request $request)
    {

        $this->initBaseEvent(Events::INITIALIZE_ADD, new PageType());
        return $this->add($request);
    }

    public function deleteAction(Request $request)
    {

        $this->initBaseEvent(Events::INITIALIZE_DELETE);
        return $this->delete($request);
    }

    public function markAction(Request $request)
    {
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
        $controller = $this;
        $dispatcher->addListener(Events::INITIALIZE_EDIT, function (ControllerEvent $event) use ($controller) {

            $form = $controller->createFormBuilder(null, array('compound' => true))
                ->add('name', 'hidden')
                ->getForm();
            $event->setDataManager($this->get('admin.page.manager'))
//                ->setUploaderManager($this->get('admin.page.uploader'))
                ->setFrom($form);

        });

        $dispatcher->addListener(Events::FORM_SUCCESS_VALIDATE_EDIT, function (ControllerEvent $event) use ($controller) {

            $form = $event->getForm();
            $entity = $event->getDataManager()->getEntity();
            $data = $form->getData();
            if ($data['name'] == 'isShow') {
                $entity->setIsShow(!$entity->getIsShow());
                $event->getDataManager()->save($entity);
                $event->setResponse(new Response('Ok'));
            } else {
                $event->setResponse(new Response('Method not allowed', Response::HTTP_NOT_FOUND));
            }
        });

        $dispatcher->addListener(Events::FINAL_EDIT, function (ControllerEvent $event) {
            $event->setResponse(new Response('Method not allowed', Response::HTTP_NOT_FOUND));
        });
        return $this->edit($request);
    }

//    public function ajaxEditFieldAction(Request $request)
//    {
//        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
//        $dispatcher = $this->get('event_dispatcher');
//        $controller = $this;
//        $this->initBaseEvent(Events::INITIALIZE_EDIT);
//
//        $dispatcher->addListener(Events::LOAD_ENTITY_EDIT,function(ControllerEvent $event) use ($controller){
//            $entity = $event->getDataManager()->getEntity();
//            $form = $controller->createFormBuilder($entity, array('compound' => true))
//                ->add('name', 'hidden')
//                ->add('edit_field_name', 'hidden', array('mapped' => false))
//                ->getForm();
//            $event->setFrom($form);
//        });
//
//        $dispatcher->addListener(Events::ENTITY_SUCCESS_EDIT, function (ControllerEvent $event){
//            $event->setResponse(new Response('Ok'));
//        });
//
//        $dispatcher->addListener(Events::FINAL_EDIT, function (ControllerEvent $event) {
//            $event->setResponse(new Response('Method not allowed', Response::HTTP_NOT_FOUND));
//        });
//
//        return $this->edit($request);
//    }


    protected function initBaseEvent($eventName, AbstractType $formType = null)
    {
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
        $dispatcher->addListener($eventName, function (ControllerEvent $event) use ($formType) {
            $event->setDataManager($this->get('admin.page.manager'));
//                ->setUploaderManager($this->get('admin.page.uploader'));
            if ($formType) {
                $event->setFormType($formType);
            }
        });
    }

}
