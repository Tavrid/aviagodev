<?php


namespace Acme\AdminBundle\Entity;


use Doctrine\ORM\Mapping as ORM;


class Tickets
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $type = 1;

    /**
     * @var \Acme\AdminBundle\Entity\AviaAirports
     */
    protected $cityFrom;

    /**
     * @var \Acme\AdminBundle\Entity\AviaAirports
     */
    protected $cityTo;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $isEnabled = true;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return Tickets
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCityFrom()
    {
        return $this->cityFrom;
    }

    /**
     * @param AviaAirports $cityFrom
     * @return Tickets
     */
    public function setCityFrom(AviaAirports $cityFrom)
    {
        $this->cityFrom = $cityFrom;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCityTo()
    {
        return $this->cityTo;
    }

    /**
     * @param AviaAirports $cityTo
     * @return Tickets
     */
    public function setCityTo(AviaAirports $cityTo)
    {
        $this->cityTo = $cityTo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * @param mixed $isEnabled
     * @return Tickets
     */
    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;
        return $this;
    }


}