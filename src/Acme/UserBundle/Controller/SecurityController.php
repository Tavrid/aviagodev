<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 17.03.14
 * Time: 22:36
 */

namespace Acme\UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as Controller;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller {

    public function loginAction(Request $request)
    {
        /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $session = $request->getSession();

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        if ($error) {
            // TODO: this is a potential security risk (see http://trac.symfony-project.org/ticket/9523)
            $error = $error->getMessage();
        }
        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

        $csrfToken = $this->container->has('form.csrf_provider')
            ? $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate')
            : null;
        $data = array(
            'last_username' => $lastUsername,
            'error'         => $error,
            'csrf_token' => $csrfToken,
            'fb_login_url' => false,
            'login_path' => $this->container->get('router')->generate('user.security.facebook.check')
        );
        if($request->get('_route') !== 'user.security.facebook.login'){
            $redirect_url = $this->container->get('router')->generate('user.facebook.facebook_authenticate',array(),true);
            $data['fb_login_url'] = $this->container->get('facebook.manager')->getLoginUrl($redirect_url);
            $data['login_path'] = $this->container->get('router')->generate('fos_user_security_check');
        }

        return $this->container->get('templating')->renderResponse('AcmeUserBundle:Security:login.html.twig',$data);
    }


} 