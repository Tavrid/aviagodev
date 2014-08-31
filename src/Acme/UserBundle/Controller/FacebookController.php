<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 02.04.14
 * Time: 16:08
 */

namespace Acme\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;


class FacebookController extends Controller {

    function facebookAuthenticateAction(Request $request){
        $facebook = $this->get('facebook.manager');
        if(!$facebook->getUser()){
            throw new \Exception('error get user from facebook');
        }
        $fbData = $facebook->getData();
        /** @var \Symfony\Component\Security\Core\SecurityContext $context */
        $context = $this->get('security.context');
        $data = array(
            'facebookData' => $fbData
        );
        if(!$context->isGranted('ROLE_USER')){
            return $this->render('AcmeUserBundle:Facebook:choice.html.twig',$data);
        } else {
            $url = $this->get('router')->generate('bundles_default_homepage');
            return new RedirectResponse($url);
        }

    }

    function userNoActivatedAction(Request $request){
        $email =$this->get('session')->get('fb.no.activated.email');
        if(!$email){
            throw $this->createNotFoundException('Email error');
        }
        $this->get('session')->remove('fb.no.activated.email');
        return new Response(sprintf('Пользователь %s не подтвержденн',$email));
    }

} 