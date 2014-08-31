<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 17.03.14
 * Time: 20:45
 */

namespace Acme\UserBundle\Security\Firewall;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Acme\UserBundle\Security\Authentication\Token\FacebookUserToken;
use Symfony\Component\DependencyInjection\ContainerInterface;
use  	Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Acme\UserBundle\Model\UserSocialInterface;

class FacebookListener implements ListenerInterface
{
    protected $securityContext;
    protected $authenticationManager;
    /**
     * @var UserSocialInterface
     */
    protected  $social;
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    public function __construct(SecurityContextInterface $securityContext,
                                AuthenticationManagerInterface $authenticationManager,
                                UserSocialInterface $social,
                                ContainerInterface $container)
    {
        $this->securityContext = $securityContext;
        $this->authenticationManager = $authenticationManager;
        $this->social = $social;
        $this->container = $container;
    }

    public function handle(GetResponseEvent $event)
    {

        $user = null;
        try {

            if(!$this->social->getSocialId()){
                return;
            }
        } catch (\FacebookApiException $e) {

            return;
        }
        $token = new FacebookUserToken();
        $token->setUser($this->social->getSocialId());

        try {
            $authToken = $this->authenticationManager->authenticate($token);
            if(!$authToken->getUser()->isEnabled()){
                $this->container->get('session')->set('fb.no.activated.email',$authToken->getUser()->getEmail());
                $url = $this->container->get('router')->generate('user.facebook.not_confirmed');
                $response = new RedirectResponse($url);
                $event->setResponse($response);
                return;
            }
            $this->securityContext->setToken($authToken);
        } catch (AuthenticationException $failed) {
        }
        return;

    }
}