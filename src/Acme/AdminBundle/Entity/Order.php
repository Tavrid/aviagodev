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


class Order extends AbstractEntity
{

    /**
     * @var integer
     */
    protected $id;
    /**
     * @var integer
     */
    /**
     * @var string
     */
    protected $state;
    /**
     * @var string
     */
    protected $phone;

    protected $email;
    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @var array
     */
    protected $passengers;
    /**
     * @var array
     */
    protected $info;

    const STATE_DEALING = 1;
    const STATE_PAYED = 2;
    const STATE_CANCEL = 3;
    const STATE_SUCCESS = 4;

    public static $states = array(
        self::STATE_CANCEL => 'Отменен',
        self::STATE_DEALING => 'В ожидании',
        self::STATE_PAYED => 'Оплачен',
        self::STATE_SUCCESS => 'Выполнен',
    );

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->state = self::STATE_DEALING;
        $this->info = "info";
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {

        $metadata->addPropertyConstraint('state', new Assert\NotBlank())
            ->addPropertyConstraint('email', new Assert\Email());


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
     * Set state
     *
     * @param string $state
     * @return Order
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
     * @return Order
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

    /**
     * Set passengers
     *
     * @param string $passengers
     * @return Order
     */
    public function setPassengers($passengers)
    {
        $this->passengers = json_encode($passengers);

        return $this;
    }

    /**
     * Get passengers
     *
     * @return string
     */
    public function getPassengers()
    {
        return json_decode($this->passengers,true);
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
     * Set phone
     *
     * @param string $phone
     * @return Order
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Order
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
}
