<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 25.03.14
 * Time: 11:00
 */

namespace Acme\UserBundle\Security\Authentication\Provider;

use FOS\UserBundle\Security\UserProvider as FosUserProvider;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class UserProvider extends FosUserProvider {

    /**
     * {@inheritDoc}
     */
    public function loadUserByFacebookId($username)
    {

        $user = $this->userManager->findUserByFacebookId($username);

        if (!$user) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }

        return $user;
    }

} 