<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 02.04.14
 * Time: 15:34
 */

namespace Acme\UserBundle\Model;
use FOS\UserBundle\Doctrine\UserManager as FOSUserManage;

class UserManager extends FOSUserManage {

    /**
     * Finds a user by username
     *
     * @param string $fbId
     *
     * @return UserInterface
     */
    public function findUserByFacebookId($fbId)
    {

        return $this->findUserBy(array('fbId' => $fbId));
    }

    /**
     * Returns an empty user instance
     *
     * @return UserInterface
     */
    public function createUser()
    {
        $class = $this->getClass();
        $user = new $class;

        return $user;
    }

} 