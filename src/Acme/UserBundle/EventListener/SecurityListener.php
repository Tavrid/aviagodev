<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 26.03.14
 * Time: 15:13
 */

namespace Acme\UserBundle\EventListener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Acme\UserBundle\Model\UserManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SecurityListener {
    /**
     * @var \Acme\UserBundle\Model\UserManager
     */
    protected $userManager;

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */

    protected $container;

    public function __construct(UserManager $userManager,ContainerInterface $container)
    {
        $this->userManager = $userManager;
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event){

        if($event->getRequest()->get('_route') == 'user.security.facebook.check'){
            /** @var \Acme\UserBundle\Entity\User $user */
            $facebook = $this->container->get('facebook.manager');
            $user = $event->getAuthenticationToken()->getUser();
            $fbId = $facebook->getUser();
            if(!$fbId){
                throw new \Exception('Error user id');
            }
            $user->setFbId($fbId);
            $this->userManager->updateUser($user);
        }
    }
}