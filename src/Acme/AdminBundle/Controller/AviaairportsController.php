<?php

namespace Acme\AdminBundle\Controller;

use Acme\BootstrapBundle\ColumnTypes;
use Symfony\Component\Form\AbstractType;
use Acme\AdminBundle\Form\Type\AviaairportsType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Acme\AdminBundle\AcmeAdminBundleEvents as Events;
use Acme\AdminBundle\Event\ControllerEvent;



class AviaairportsController extends ControllerBase {

    public function indexAction(Request $request) {
        /* @var $manager \Acme\AdminBundle\Model\Airports */
        $manager = $this->get('admin.city.manager');
        $queryBuilder = $manager->getRepository()
                ->createQueryBuilder('p')
                ->orderBy('p.regionRus')
                ;
        $p = $manager->paginator($request->get('page', 1), $queryBuilder, 'admin.aviaairports.index',20);

        return $this->render('AcmeAdminBundle:Aviaairports:index.html.twig', array(
            'data' => $p[0],
            'pagerHtml' => $p[1],
            'params' => array(
                'columns' => array(
                    'id',
                    'cityCodeEng',
                    'airportCodeEng',
                    'regionRus',
                    'regionEng',
                    'countryRus',
                    'countryEng',
                    'cityEng',
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
