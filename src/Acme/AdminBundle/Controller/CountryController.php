<?php

namespace Acme\AdminBundle\Controller;

use Acme\BootstrapBundle\ColumnTypes;
use Symfony\Component\Form\AbstractType;
use Acme\AdminBundle\Form\Type\CountryType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Acme\AdminBundle\AcmeAdminBundleEvents as Events;
use Acme\AdminBundle\Event\ControllerEvent;
use Doctrine\ORM\Query\Expr;

class CountryController extends ControllerBase {

    public function indexAction(Request $request) {
        /* @var $manager \Acme\AdminBundle\Model\Airports */
        $manager = $this->get('country.model.manager');
        $queryBuilder = $manager->getRepository()
                ->createQueryBuilder('p')
                ->orderBy('p.passport_mask','DESC')
                ->addOrderBy('p.name')
        ;

        $p = $manager->paginator($request->get('page', 1), $queryBuilder, 'admin.country.index', 20);

        return $this->render('AcmeAdminBundle:Aviaairports:index.html.twig', array(
                    'data' => $p[0],
                    'pagerHtml' => $p[1],
                    'params' => array(
                        'columns' => array(
                            'id',
                            'name',
                            'passportMask',
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
