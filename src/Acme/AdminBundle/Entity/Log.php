<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 14.09.14
 * Time: 22:02
 */

namespace Acme\AdminBundle\Entity;

use Acme\CoreBundle\Entity\AbstractEntity;

use Symfony\Component\Validator\Constraints as Assert;
use Acme\CoreBundle\Validator\Multifield;
use Symfony\Component\Validator\Mapping\ClassMetadata;


class Log extends AbstractEntity
{

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $info;
    /**
     * @var string
     */

    /**
     * @var \DateTime
     */
    protected $date;

    public function __construct(){
        $this->date = new \DateTime();
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
     * Set info
     *
     * @param string $info
     * @return Order
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Get info
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }
    /**
     * @var string
     */
    private $state;


    /**
     * Set state
     *
     * @param string $state
     * @return Log
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Log
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }
}
