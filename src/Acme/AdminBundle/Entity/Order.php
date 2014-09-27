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
    /**
     * @var string
     */

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
     * @var float
     */
    protected $price;
    /**
     * @var string
     */
    protected $order_id;
    /**
     * @var array
     */
    protected $info;

    const STATE_DEALING = 1;
    const STATE_PAYED = 2;
    const STATE_CANCEL = 3;
    const STATE_SUCCESS = 4;

    public static $states = array(
        self::STATE_DEALING => 'В ожидании',
        self::STATE_PAYED => 'Оплачен',
        self::STATE_CANCEL => 'Отменен',
        self::STATE_SUCCESS => 'Выполнен',
    );

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->state = self::STATE_DEALING;
        $this->info = "info";
        $this->order_id = md5(microtime().uniqid().'avia_go');
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {

        $metadata->addPropertyConstraint('state', new Assert\NotBlank())
            ->addPropertyConstraint('email', new Assert\Email())
            ->addPropertyConstraint('price', new Assert\NotBlank())
        ;


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

    public function getStateName(){
        return self::$states[$this->state];
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
        $this->passengers = $passengers;

        return $this;
    }

    /**
     * Get passengers
     *
     * @return string
     */
    public function getPassengers()
    {
        return $this->passengers;
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

    /**
     * Set price
     *
     * @param float $price
     * @return Order
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set order_id
     *
     * @param string $orderId
     * @return Order
     */
    public function setOrderId($orderId)
    {
        $this->order_id = $orderId;

        return $this;
    }

    /**
     * Get order_id
     *
     * @return string 
     */
    public function getOrderId()
    {
        return $this->order_id;
    }
}
