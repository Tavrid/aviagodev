<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 11.10.14
 * Time: 14:05
 */

namespace Bundles\ApiBundle\Api\Entity;


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

    protected $date;

    /**
     * @param $data
     * @param $date
     * @param $isRoot
     */
    public function __construct($data,$date,$isRoot = true){
        $this->child = array();
        $this->price = isset($data['TotalPrice']['Total']) ? $data['TotalPrice']['Total'] : null;
        $this->date = strtotime($date);
        if($isRoot){
            foreach($data as $de => $da){
                if(!strtotime($de)){
                    continue;
                }
                $this->addChild(new Calendar($da,$de,false));
            }
        }
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





} 