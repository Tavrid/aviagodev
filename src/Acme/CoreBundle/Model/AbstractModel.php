<?php

namespace Acme\CoreBundle\Model;

use Acme\AdminBundle\Entity\Order;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Acme\CoreBundle\Repository\AbstractRepository;
//use paginator
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrapView;


abstract class AbstractModel
{

    /**
     *
     * @var object $entity entity class
     *
     */
    protected $entity;

    /**
     *
     * @var string
     */
    protected $entityClass;

    /**
     *
     * @var \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    protected $container;

    /**
     * @var \Acme\CoreBundle\Repository\AbstractRepository
     */
    protected $repository;

    /**
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param string $entity
     *
     */
    public function __construct(ContainerInterface $container, $entity)
    {
        if ($entity) {
            $this->entityClass = $entity;
//            $this->setEntity(new $entity);
        }
        $this->container = $container;
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository($entity);

        $this->setRepository($repository);
    }


    public function __call($name, $arguments)
    {
        return call_user_func_array(array($this->getRepository(), $name), $arguments);
    }





    public function setEntity($entity)
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     * @return Order
     */
    public function getEntity()
    {
        if (!$this->entity) {
            $this->entity = new $this->entityClass;
        }
        return $this->entity;
    }

    public function save($entity = NULL)
    {
        if ($entity) {
            $this->setEntity($entity);
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($this->getEntity());
        return $em->flush();
    }

    public function remove($entity = NULL)
    {
        if ($entity) {
            $this->setEntity($entity);
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($this->getEntity());
        return $em->flush();
    }

    public function getDoctrine()
    {
        return $this->container->get('doctrine');
    }

    public function __toString()
    {
        return $this->entityClass;
    }

    /**
     * @return \Acme\CoreBundle\Repository\AbstractRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    public function setRepository(\Doctrine\ORM\EntityRepository $repository){
        $this->repository = $repository;
    }

    /**
     * @param Request $request
     * @param $id
     * @param $mark
     * @return bool
     * @throws \Exception
     */

    public function mark(Request $request, $id, $mark)
    {
        $entity = $this->getRepository()->find($id);
        if (!$entity) {
            throw new \Exception('Unable to find GoodsItems entity.');
        }

        $form = $this->container->get('form.factory')
            ->createBuilder('form', $entity, array(
                'csrf_protection' => true,
                'csrf_field_name' => '_token',
                'intention'       => 'ablyakim.cmf'
            ))
            ->add($mark, 'hidden')
            ->getForm();
        $form->submit($request);
        if ($form->isValid()) {
            $this->save($entity);
            return true;
        } else {
            throw new \Exception('Form is not Valid!');
        }

    }


    public function changePosition($id, $position = 1, $parent = 0, $isUseParent = true)
    {
        $entity = $this->getRepository()->find($id);
        if ($isUseParent) {
            if ($parent) {
                $parent = $this->getRepository()->find($parent);
                if (!$parent) {
                    throw new \Exception ('Parent not exist!');
                }
            }
            $entity->setParent($parent);
        }
        $entity->setPosition($position);
        return $this->save($entity);
    }


    /**
     * Get results from paginator and get paginator view.
     *
     */
    public function paginator($page,\Doctrine\ORM\QueryBuilder $queryBuilder, $url, $maxPerPage = null,$extUrlParams=[])
    {

        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        if ($maxPerPage) {
            $pagerfanta->setMaxPerPage($maxPerPage);
        }

        $currentPage = $page;
        $pagerfanta->setCurrentPage($currentPage);
        $entities = $pagerfanta->getCurrentPageResults();
        if ($pagerfanta->getNbPages() > 1) {
            // Paginator - route generator
            $me = $this;
            $routeGenerator = function ($page) use ($me, $url,$extUrlParams) {
                return $me->container->get('router')->generate($url, array_merge($extUrlParams,array('page' => $page)));
            };

            // Paginator - view
            $translator = $this->container->get('translator');
            $view = new TwitterBootstrapView();
            $pagerHtml = $view->render($pagerfanta, $routeGenerator, array(
                'proximity' => 3,
                'prev_message' => $translator->trans('views.index.pagprev', array(), 'crud'),
                'next_message' => $translator->trans('views.index.pagnext', array(), 'crud'),
            ));
        } else {
            $pagerHtml = NULL;
        }
        return array($entities, $pagerHtml);
    }


}
