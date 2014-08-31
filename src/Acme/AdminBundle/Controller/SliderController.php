<?php

namespace Acme\AdminBundle\Controller;

use Stb\Bootstrap\ColumnTypes;

use Symfony\Component\Form\AbstractType;
use Acme\AdminBundle\Form\Type\SliderType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Acme\AdminBundle\AcmeAdminBundleEvents as Events;
use Acme\AdminBundle\Event\ControllerEvent;

class SliderController extends ControllerBase
{

    public function indexAction(Request $request)
    {

        $data = $this->get('admin.slider.manager')->getAll();

        return $this->render('AcmeAdminBundle:Slider:list.html.twig', array(
            'data' => $data,

            'params' => array(
                'columns' => array(
                    'id',
                    array('name' => 'name',
                        'header' => 'Заголовок',
                    ),
                    array('name' => 'isShow',
                        'header' => 'Видимость',
                        'type' => ColumnTypes::TYPE_BOOL_EDITABLE,
                        'route' => array('admin.slider.mark',array('id' => 'id'))
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
                        'route' => array('admin.slider.edit', array('id' => 'id'))
                    ),
                    'delete' => array(
                        'route' => array('admin.slider.delete', array('id' => 'id'))
                    ),
                    'sortable' => array(
                        'icon' => 'icon-move',
                        'type' => ColumnTypes::TYPE_ICON,
                        'class' => 'move'
                    ),
                )
            )
        ));
    }

    public function editAction(Request $request)
    {

        $this->initBaseEvent(Events::INITIALIZE_EDIT, new SliderType());
        return $this->edit($request);
    }

    public function addAction(Request $request)
    {

        $this->initBaseEvent(Events::INITIALIZE_ADD, new SliderType());
        return $this->add($request);
    }

    public function deleteAction(Request $request)
    {

        $this->initBaseEvent(Events::INITIALIZE_DELETE);
        return $this->delete($request);
    }


    public function changePositionAction(Request $request){
        $manager = $this->get('admin.slider.manager');
        $position = (int) $request->get('newPosition');
        $id = (int) $request->get('id');
        $manager->changePosition($id, $position,null,false);

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
            $event->setDataManager($this->get('admin.slider.manager'))
//                ->setUploaderManager($this->get('admin.page.uploader'))
                ->setResponse(new Response('Method not allowed', Response::HTTP_NOT_FOUND))
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

        return $this->edit($request);
    }


    protected function initBaseEvent($eventName, AbstractType $formType = null)
    {
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
        $dispatcher->addListener($eventName, function (ControllerEvent $event) use ($formType) {
            $event->setDataManager($this->get('admin.slider.manager'))
                ->setUploaderManager($this->get('admin.slider.uploader'));
            if ($formType) {
                $event->setFormType($formType);
            }
        });
    }

}
