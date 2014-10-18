<?php

namespace Acme\AdminBundle\Controller;

use Stb\Bootstrap\ColumnTypes;
use Stb\Bootstrap\Response\EditableTextResponse;
use Symfony\Component\Form\AbstractType;
use Acme\AdminBundle\Form\Type\CountryType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Acme\AdminBundle\AcmeAdminBundleEvents as Events;
use Acme\AdminBundle\Event\ControllerEvent;
use Acme\AdminBundle\Entity\Country;

class CountryController extends ControllerBase {

    public function indexAction(Request $request) {
        /* @var $manager \Acme\AdminBundle\Model\Airports */
        $manager = $this->get('country.model.manager');
        $queryBuilder = $manager->getRepository()
                ->createQueryBuilder('p')
                ->orderBy('p.passport_mask', 'DESC')
                ->addOrderBy('p.name');

        $p = $manager->paginator($request->get('page', 1), $queryBuilder, 'admin.country.index', 20);
        $controller = $this;
        return $this->render('AcmeAdminBundle:Country:index.html.twig', array(
                    'data' => $p[0],
                    'pagerHtml' => $p[1],
                    'params' => array(
                        'columns' => array(
                            'id',
                            'name',
                            [
                                'name' => 'passportMask',
                                'header' => 'Статус',
                                'type' => ColumnTypes::TYPE_EDITABLE_TEXT,
                                'route' => ['admin.country.editmask', ['id' => 'id']],
                                'form' => function(Country $country) use ($controller) {
                            return $controller->createFormBuilder($country)
                                            ->add('passportMask')
                                            ->getForm()->createView();
                        }
                            ],
                            'alpha2',
                            'code',
                        ),
                        'actions' => array(
                            'edit' => array(
                                'route' => array('admin.country.edit', array('id' => 'id'))
                            ),
                            'delete' => array(
                                'route' => array('admin.country.delete', array('id' => 'id'))
                            ),
                        )
                    )
        ));
    }

    public function editMaskAction(Request $request) {

        /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
        $controller = $this;
        $dispatcher->addListener(Events::INITIALIZE_EDIT, function (ControllerEvent $event) {


            $event->setDataManager($this->get('country.model.manager'));
        });
        $dispatcher->addListener(Events::LOAD_ENTITY_EDIT, function(ControllerEvent $event) use ($controller) {
            $form = $controller->createFormBuilder($event->getDataManager()->getEntity())
                    ->add('passportMask')
                    ->getForm();
            $event->setFrom($form);
        });

        $dispatcher->addListener(Events::ENTITY_SUCCESS_EDIT, function (ControllerEvent $event) {
            $form = $event->getForm();
            $entity = $event->getDataManager()->getEntity();
            $renderedForm = $this->renderView(
                    "AcmeAdminBundle:Country:_mask_form.html.twig", array("form" => $form->createView())
            );
            $event->setResponse(new EditableTextResponse($renderedForm, $entity->getPassportMask()));
        });
        return $this->edit($request);
    }

    public function editAction(Request $request) {

        $this->initBaseEvent(Events::INITIALIZE_EDIT, new CountryType());
        return $this->edit($request);
    }

    public function addAction(Request $request) {

        $this->initBaseEvent(Events::INITIALIZE_ADD, new CountryType());
        return $this->add($request);
    }

    public function deleteAction(Request $request) {

        $this->initBaseEvent(Events::INITIALIZE_DELETE);
        return $this->delete($request);
    }

    protected function initBaseEvent($eventName, AbstractType $formType = null) {
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
        $dispatcher->addListener($eventName, function (ControllerEvent $event) use ($formType) {
            $event->setDataManager($this->get('country.model.manager'))
            ;
            if ($formType) {
                $event->setFormType($formType);
            }
        });
    }

}
