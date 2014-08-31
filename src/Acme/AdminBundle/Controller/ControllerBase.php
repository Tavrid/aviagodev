<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29.03.14
 * Time: 13:48
 */

namespace Acme\AdminBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Acme\AdminBundle\Form\Type\ProjectType;
use Acme\AdminBundle\AcmeAdminBundleEvents as Events;
use Acme\AdminBundle\Event\ControllerEvent;
use Acme\AdminBundle\Routing\RouteName;

class ControllerBase extends Controller
{


    protected function edit(Request $request){

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $eventInitialize = new ControllerEvent($request);
        if(!$dispatcher->hasListeners(Events::INITIALIZE_EDIT)){
            throw new \Exception('You must add listener initialize Events::INITIALIZE_EDIT');
        }

        $dispatcher->dispatch(Events::INITIALIZE_EDIT,$eventInitialize);
        $form = $eventInitialize->getForm();
        $response = $eventInitialize->getResponse();


        $id = (int) $request->get('id');
        $manager = $eventInitialize->getDataManager();
        $entity = $manager->find($id);
        $manager->setEntity($entity);

        $eventEntityLoad = new ControllerEvent($request);
        $eventEntityLoad->setDataManager($manager);

        $dispatcher->dispatch(Events::LOAD_ENTITY_EDIT,$eventEntityLoad);
        if($eventEntityLoad->getForm()){
            $form = $eventEntityLoad->getForm();
        }
        if(!$form){
            $form = $this->createForm($eventInitialize->getFormType(),$entity);
        }


        if($request->getMethod() === 'POST'){
            $form->submit($request);
            if($form->isValid()){

                $eventSuccess = new ControllerEvent($request);
                $eventSuccess->setDataManager($manager)
                    ->setFrom($form);
                $dispatcher->dispatch(Events::FORM_SUCCESS_VALIDATE_EDIT,$eventSuccess);
                if($eventSuccess->getResponse()){
                    return $eventSuccess->getResponse();
                }

                $manager->save($entity);

                $eventSuccessEdit = new ControllerEvent($request);
                $eventSuccessEdit->setDataManager($manager)
                    ->setFrom($form);
                $dispatcher->dispatch(Events::ENTITY_SUCCESS_EDIT,$eventSuccessEdit);
                if($eventSuccessEdit->getResponse()){
                    $response = $eventSuccessEdit->getResponse();
                } else if(!$response){
                    $url = $this->get('router')->generate($request->attributes->get('_route'),array('id' => $id));
                    $response = new RedirectResponse($url);

                }
                $this->get('session')->getFlashBag()->add('success', 'flash.update.success');
                return $response;

            } else {
                $eventError = new ControllerEvent($request);
                $eventError->setDataManager($manager)
                    ->setFrom($form);
                $dispatcher->dispatch(Events::FORM_ERROR_VALIDATE_EDIT,$eventError);
                if($eventError->getResponse()){
                    return $eventError->getResponse();
                }
            }
        }
        $eventFinal = new ControllerEvent($request);
        $eventFinal->setDataManager($manager)
            ->setFrom($form);
        $dispatcher->dispatch(Events::FINAL_EDIT,$eventFinal);

        if($eventFinal->getResponse()){
            $response = $eventFinal->getResponse();
        } else if(!$response){
            $response = $this->render($this->getViewPatch($request),array(
                'form' => $form->createView(),
                'service' => $eventInitialize->getUploaderManager(),
                'entity' => $entity
            ));
        }
        return $response;

    }


    protected function add(Request $request){
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $eventInitialize = new ControllerEvent($request);
        if(!$dispatcher->hasListeners(Events::INITIALIZE_ADD)){
            throw new \Exception('You must add listener initialize Events::INITIALIZE_ADD');
        }
        $dispatcher->dispatch(Events::INITIALIZE_ADD,$eventInitialize);

        $manager = $eventInitialize->getDataManager();
        $entity = $manager->getEntity();
        $form = $this->createForm($eventInitialize->getFormType(),$entity);
        if($request->getMethod() === 'POST'){
            $form->submit($request);
            if($form->isValid()){
                $eventSuccess = new ControllerEvent($request);
                $eventSuccess->setDataManager($manager)
                    ->setFrom($form);
                $dispatcher->dispatch(Events::FORM_SUCCESS_VALIDATE_ADD,$eventSuccess);
                if($eventSuccess->getResponse()){
                    return $eventSuccess->getResponse();
                }
                $manager->save($entity);
                if($uploader = $eventInitialize->getUploaderManager()){
                    $uploader->saveFiles($entity->getId());
                }
                $eventSuccessAdd = new ControllerEvent($request);
                $eventSuccessAdd->setDataManager($manager)
                    ->setUploaderManager($uploader);
                $dispatcher->dispatch(Events::ENTITY_SUCCESS_ADD,$eventSuccessAdd);
                if(!$response = $eventSuccessAdd->getResponse()){

                    $url = $this->get('router')->generate($request->attributes->get('_route'));
                    $response = new RedirectResponse($url);
                }
                $this->get('session')->getFlashBag()->add('success', 'flash.create.success');
                return $response;
            }
        }
        $eventFinal = new ControllerEvent($request);
        $eventFinal->setDataManager($manager)
            ->setFrom($form);
        $dispatcher->dispatch(Events::FINAL_ADD,$eventFinal);

        if(!$response = $eventFinal->getResponse()){
            $response = $this->render($this->getViewPatch($request),array(
                'form' => $form->createView(),
                'service' => $eventInitialize->getUploaderManager()
            ));
        }
        return $response;

    }

    public function delete(Request $request){

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        if(!$dispatcher->hasListeners(Events::INITIALIZE_DELETE)){
            throw new \Exception('You must add listener initialize Events::INITIALIZE_ADD');
        }
        $eventInitialize = new ControllerEvent($request);
        $dispatcher->dispatch(Events::INITIALIZE_DELETE,$eventInitialize);

        $manager = $eventInitialize->getDataManager();

        $id = (int) $request->get('id');
        $entity = $manager->find($id);
        $form = $this->createFormBuilder($entity)->getForm();
        $form->submit($request);
        if($form->isValid()){
            $eventSuccessValidate = new ControllerEvent($request);
            $eventSuccessValidate->setDataManager($manager)
                ->setFrom($form);
            $dispatcher->dispatch(Events::FORM_SUCCESS_VALIDATE_DELETE,$eventSuccessValidate);
            if($eventSuccessValidate->getResponse()){
                return $eventSuccessValidate->getResponse();
            }

            $em = $manager->getDoctrine()->getManager();

            $em->getConnection()->beginTransaction(); // suspend auto-commit
            try {
                if($uploader = $eventInitialize->getUploaderManager()){
                    $uploader->removeFilesByEntityId($id);
                }
                $manager->remove($entity);
                $em->getConnection()->commit();
            } catch (Exception $e) {
                $em->getConnection()->rollback();
                $em->close();
                throw $e;
            }


            $eventSuccessDelete = new ControllerEvent($request);
            $eventSuccessDelete->setDataManager($manager)
                            ->setUploaderManager($uploader);

            $dispatcher->dispatch(Events::ENTITY_SUCCESS_DELETE,$eventSuccessDelete);
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
            if(!$response = $eventSuccessDelete->getResponse()){
                $response = new Response('Ok');
            }

            return $response;
        }
        throw $this->createNotFoundException('Error save');
    }






    protected function getViewPatch(Request $request){
        $str = $request->attributes->get('_controller');
        $math = preg_match('/([\w]+)Controller::([\w]+)Action/i',$str,$matches);
        $f = 'AcmeAdminBundle:%s:%s.html.twig';
        return sprintf($f,$matches[1],$matches[2]);
    }
}