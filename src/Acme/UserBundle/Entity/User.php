<?php

/**
 * Users.php (UTF-8)
 *
 * Jun 18, 2013 9:36:34 PM
 * @author abdulhakim
 */

namespace Acme\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="`fb_id`", type="string", length=300, nullable=true)
     */
    protected $fbId;

    public function __construct() {
        parent::__construct();
        $this->roles = array('ROLE_USER');
        // your own logic
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fbId
     *
     * @param string $fbId
     * @return User
     */
    public function setFbId($fbId)
    {
        $this->fbId = $fbId;

        return $this;
    }

    /**
     * Get fbId
     *
     * @return string
     */
    public function getFbId()
    {
        return $this->fbId;
    }
}
