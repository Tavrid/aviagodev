<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 11.10.14
 * Time: 14:05
 */

namespace Bundles\ApiBundle\Api\Entity;


use Bundles\ApiBundle\Api\Query\QueryAbstract;
use Bundles\ApiBundle\Api\EntityCreator\TicketEntityCreatorInterface;

class Calendar {
    /**
     * @var Calendar[]
     */
    protected $child;
    /**
     * @var string
     */
    protected $data;
    /**
     * @var float
     */
    protected $price;
    
    protected $currency;

    protected $date;
    /**
     * @var Ticket
     */
    protected $ticket;
    /**
     * @var Calendar
     */
    protected $parent;
    /**
     * @var string
     */
    protected $requestId;


    protected $query;
    /**
     * @var TicketEntityCreatorInterface
     */
    protected $ticketCreator;
    /**
     * @return Calendar
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Calendar $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }


    /**
     * @param $data
     * @param $date
     * @param TicketEntityCreatorInterface $ticketCreator
     * @param QueryAbstract $query
     * @param bool $isRoot
     */
    public function __construct($data,$date,TicketEntityCreatorInterface $ticketCreator,QueryAbstract $query = null,$isRoot = true){
        $this->ticketCreator =$ticketCreator;
        $this->query = $query;
        $this->data = $data;
        $this->child = array();
        $price = $ticketCreator->getPriceResolver()->resolve($data, $query);
        $this->price = $price['price']['Total'];
        $this->currency = $price['currency'];
        $this->date = strtotime($date);
        if($isRoot){
            foreach($data as $de => $da){
                if(!strtotime($de)){
                    continue;
                }
                $calendar = new Calendar($da,$de,$ticketCreator,$query,false);
                $calendar->setParent($this);
                $this->addChild($calendar);
            }
        }
    }
    public function getCurrency() {
        return $this->currency;
    }

    public function setCurrency($currency) {
        $this->currency = $currency;
        return $this;
    }

    public function  getRequestId(){
        if($this->parent){
            return $this->parent->getRequestId();
        } else {
            return $this->requestId;
        }
    }

    public function setRequestId($requestId){
        $this->requestId = $requestId;
    }

        /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     * @return $this
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }



    /**
     * @param Calendar $calendar
     * @return $this
     */
    public function addChild(Calendar $calendar){
        $calendar->setParent($this);
        $this->child[$calendar->getDate()] = $calendar;

        return $this;
    }
    public function findChild($key){
        if(isset($this->child[$key])){
            return $this->child[$key];
        }
        return null;
    }

    /**
     * @return Calendar[]
     */
    public function getChild()
    {
        return $this->child;
    }

    /**
     * @param Calendar[] $child
     * @return $this
     */
    public function setChild($child)
    {
        $this->child = $child;
        return $this;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }


    /**
     * @return Ticket
     */
    public function getTicket(){
        if(!$this->ticket){
            $this->ticket = $this->ticketCreator->createTicket($this->getData(),$this->query);

        }
        return $this->ticket;
    }
//
//    /**
//     * @param Ticket $ticket
//     * @return $this
//     */
//
//    public function setTicket(Ticket $ticket){
//        $this->ticket = $ticket;
//        return $this;
//    }





} 