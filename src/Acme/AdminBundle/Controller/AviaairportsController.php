<?php

namespace Acme\AdminBundle\Controller;

use Acme\AdminBundle\Entity\AviaAirports;
use Stb\Bootstrap\Response\EditableTextResponse;
use Symfony\Component\Form\AbstractType;
use Acme\AdminBundle\Form\Type\AviaairportsType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Acme\AdminBundle\AcmeAdminBundleEvents as Events;
use Acme\AdminBundle\Event\ControllerEvent;

use Acme\AdminBundle\Form\Type\AviaAirportsFilter;

class AviaairportsController extends ControllerBase {

    public function indexAction(Request $request) {

        $manager = $this->get('admin.city.manager');
        $filterForm = $this->createForm(new AviaAirportsFilter());
        $filterForm->submit($request);

        $p =$manager->listItemsShowHidden($request->get('page',1),$filterForm->getData());
        $controller = $this;

        return $this->render('AcmeAdminBundle:Aviaairports:index.html.twig', array(
            'filterForm' => $filterForm->createView(),
            'data' => $p[0],
            'pagerHtml' => $p[1],
            'params' => array(
                'columns' => array(
                    'id',
                    [
                        'name' => 'nameShortRu',
                        'header' => 'Подстановка(ru)',
                        'type' => \Stb\Bootstrap\ColumnTypes::TYPE_EDITABLE_TEXT,
                        'route' => ['admin.aviaairports.editshort', ['id' => 'id']],
                        'form' => function(AviaAirports $aviaAirports) use ($controller) {
                            return $controller->createFormBuilder($aviaAirports)
                                ->add('nameShortRu','text',['label' => 'Название','required' => false])
                                ->add('lang','hidden',['data' => 'ru','mapped' => false])
                                ->getForm()
                                ->createView();
                        }

                    ],
                    [
                        'name' => 'nameShortEn',
                        'header' => 'Подстановка(en)',
                        'type' => \Stb\Bootstrap\ColumnTypes::TYPE_EDITABLE_TEXT,
                        'route' => ['admin.aviaairports.editshort', ['id' => 'id']],
                        'form' => function(AviaAirports $aviaAirports) use ($controller) {
                            return $controller->createFormBuilder($aviaAirports)
                                ->add('nameShortEn','text',['label' => 'Название','required' => false])
                                ->add('lang','hidden',['data' => 'en','mapped' => false])
                                ->getForm()
                                ->createView();
                        }

                    ],
                    [
                        'name' => 'nameShortUk',
                        'header' => 'Подстановка(ua)',
                        'type' => \Stb\Bootstrap\ColumnTypes::TYPE_EDITABLE_TEXT,
                        'route' => ['admin.aviaairports.editshort', ['id' => 'id']],
                        'form' => function(AviaAirports $aviaAirports) use ($controller) {
                            return $controller->createFormBuilder($aviaAirports)
                                ->add('nameShortUk','text',['label' => 'Название','required' => false])
                                ->add('lang','hidden',['data' => 'uk','mapped' => false])
                                ->getForm()
                                ->createView();
                        }

                    ],
                    'cityCodeEng',
                    'airportCodeEng',
                    'regionRus',
//                            'regionEng',
                    'countryRus',
//                            'countryEng',
//                            'cityEng',
                    'cityRus',
                ),
                'actions' => array(
                    'edit' => array(
                        'route' => array('admin.aviaairports.edit', array('id' => 'id'))
                    ),
                    'delete' => array(
                        'route' => array('admin.aviaairports.delete', array('id' => 'id'))
                    ),
                )
            )
        ));
    }

    public function editShortAction(Request $request){

        /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
        $controller = $this;
        $dispatcher->addListener(Events::INITIALIZE_EDIT, function (ControllerEvent $event) {
            $event->setDataManager($this->get('admin.city.manager'));
        });
        $lang = $request->get('form')['lang'];
        $dispatcher->addListener(Events::LOAD_ENTITY_EDIT, function(ControllerEvent $event) use ($controller,$lang) {

            $form = $controller->createFormBuilder($event->getDataManager()->getEntity())
                ->add('lang','hidden',['data' => 'ru','mapped' => false])
                ->add(sprintf('nameShort%s',ucfirst($lang)),'text');

            $form =$form->getForm();
            $event->setFrom($form);
        });

        $dispatcher->addListener(Events::ENTITY_SUCCESS_EDIT, function (ControllerEvent $event) use($lang) {
            $form = $event->getForm();
            $entity = $event->getDataManager()->getEntity();
            $renderedForm = $this->renderView(
                "AcmeAdminBundle:Aviaairports:_short_name_form.html.twig", array("form" => $form->createView())
            );
            $event->setResponse(new EditableTextResponse($renderedForm,call_user_func(array($entity,sprintf('getNameShort%s',ucfirst($lang))))));
        });
        return $this->edit($request);
    }


    public function editAction(Request $request) {

        $this->initBaseEvent(Events::INITIALIZE_EDIT, new AviaairportsType());
        return $this->edit($request);
    }

    public function addAction(Request $request) {

        $this->initBaseEvent(Events::INITIALIZE_ADD, new AviaairportsType());
        return $this->add($request);
    }

    public function deleteAction(Request $request) {

        $this->initBaseEvent(Events::INITIALIZE_DELETE);
        return $this->delete($request);
    }

    protected function initBaseEvent($eventName, AbstractType $formType = null) {
        /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
        $dispatcher->addListener($eventName, function (ControllerEvent $event) use ($formType) {
            $event->setDataManager($this->get('admin.city.manager'))
            ;
            if ($formType) {
                $event->setFormType($formType);
            }
        });
    }

}
