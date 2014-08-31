<?php

namespace Acme\AdminBundle\Controller;

use Stb\Bootstrap\ColumnTypes;

use Symfony\Component\Form\AbstractType;
use Acme\AdminBundle\Form\Type\MenuType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Acme\AdminBundle\AcmeAdminBundleEvents as Events;
use Acme\AdminBundle\Event\ControllerEvent;

class MenuController extends ControllerBase
{

    public function indexAction(Request $request)
    {

        $data = $this->get('admin.menu.manager')->getTree();

        return $this->render('AcmeAdminBundle:Menu:list.html.twig', array(
            'data' => $data,

            'params' => array(
                'columns' => array(
                    array('name' => 'name',
                        'header' => 'Заголовок',
                    ),
                    'id',
                    array('name' => 'isShow',
                        'header' => 'Видимость',
                        'type' => ColumnTypes::TYPE_BOOL_EDITABLE,
                        'route' => array('admin.menu.mark',array('id' => 'id'))
                    ),

                ),
                'actions' => array(
                    'view' => array(
                        'columns' => array(
                            'id',
                            array('name' => 'name'),
                        )
                    ),
                    'edit' => array(
                        'route' => array('admin.menu.edit', array('id' => 'id'))
                    ),
                    'delete' => array(
                        'route' => array('admin.menu.delete', array('id' => 'id'))
                    )
                )
            )
        ));
    }

    public function editAction(Request $request)
    {

        $this->initBaseEvent(Events::INITIALIZE_EDIT, new MenuType());
        return $this->edit($request);
    }

    public function addAction(Request $request)
    {

        $this->initBaseEvent(Events::INITIALIZE_ADD, new MenuType());
        return $this->add($request);
    }

    public function deleteAction(Request $request)
    {

        $this->initBaseEvent(Events::INITIALIZE_DELETE);
        return $this->delete($request);
    }


    public function changePositionAction(Request $request){
        $manager = $this->get('admin.menu.manager');
        $position = (int) $request->get('newPosition');
        $parent = ($request->get('parent')) ? (int) $request->get('parent') : null;
        $id = (int) $request->get('id');

        /** @var \Acme\AdminBundle\Entity\Menu $entity */
        $entity = $manager->find($id);
        $entity->setPosition($position);
        $entity->setParent($parent);
        $manager->save($entity);

        return new Response('Ok', 200);
    }


    public function markAction(Request $request)
    {
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
        $controller = $this;
        $dispatcher->addListener(Events::INITIALIZE_EDIT, function (ControllerEvent $event) use ($controller) {

            $form = $controller->createFormBuilder(null, array('compound' => true))
                ->add('name', 'hidden')
                ->add('value', 'hidden')
                ->getForm();
            $event->setDataManager($this->get('admin.menu.manager'))
//                ->setUploaderManager($this->get('admin.page.uploader'))
                ->setFrom($form);

        });

        $dispatcher->addListener(Events::FORM_SUCCESS_VALIDATE_EDIT, function (ControllerEvent $event) use ($controller) {

            $form = $event->getForm();
            $entity = $event->getDataManager()->getEntity();
            $data = $form->getData();
            if ($data['name'] == 'isShow') {
                $entity->setIsShow($data['value']);
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


    protected function initBaseEvent($eventName, AbstractType $formType = null)
    {
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
        $dispatcher->addListener($eventName, function (ControllerEvent $event) use ($formType) {
            $event->setDataManager($this->get('admin.menu.manager'));
            if ($formType) {
                $event->setFormType($formType);
            }
        });
    }

}
