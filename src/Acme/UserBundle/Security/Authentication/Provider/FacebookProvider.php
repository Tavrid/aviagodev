<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 17.03.14
 * Time: 20:48
 */

namespace Acme\UserBundle\Security\Authentication\Provider;


use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\NonceExpiredException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Acme\UserBundle\Security\Authentication\Token\FacebookUserToken;

class FacebookProvider implements AuthenticationProviderInterface
{
    private $userProvider;


    public function __construct(UserProviderInterface $userProvider)
    {
        $this->userProvider = $userProvider;

    }

    public function authenticate(TokenInterface $token)
    {

        $user = $this->userProvider->loadUserByFacebookId($token->getUsername());

        if ($user) {
            $authenticatedToken = new FacebookUserToken($user->getRoles());
            $authenticatedToken->setUser($user);
            return $authenticatedToken;
        }

        throw new AuthenticationException('The Facebook authentication failed.');
    }


    public function supports(TokenInterface $token)
    {
        return $token instanceof FacebookUserToken;
    }
}