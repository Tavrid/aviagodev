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

    protected $state;
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
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('state', new Assert\NotBlank());
//        $metadata->addPropertyConstraint('passengers', new Multifield(array('fields' => [
//                'adt' => array('sub_multi_field',
//                    'fields' => [
//                            'name' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3))],
//                            'surname' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3))],
//                            'patronymic' => ['field', new Assert\NotBlank(), new Assert\Length(array('min' => 3))],
//                            'phone' => ['field', new Assert\NotBlank()],
//                            'number_passport' => ['field', new Assert\NotBlank()],
//                            'email' => ['field', new Assert\NotBlank(), new Assert\Email()],
//                            'birthday' => ['field', new Assert\NotBlank(),new Assert\DateTime()],
//                    ],
//                ),
//            ]
//        )));

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
}
