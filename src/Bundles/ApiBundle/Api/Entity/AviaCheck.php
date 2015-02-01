<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 01.02.15
 * Time: 14:16
 */

namespace Bundles\ApiBundle\Api\Entity;
use Bundles\ApiBundle\Api\Entity\Ticket;

class AviaCheck {

    private $bookId;

    private $pnr;

    private $pnrExpireDate;

    private $totalPrice;

    private $travelers;

    private $ticket;

    private $statusPay;

    /**
     * @return mixed
     */
    public function getStatusPay()
    {
        return $this->statusPay;
    }

    /**
     * @param mixed $statusPay
     * @return $this
     */
    public function setStatusPay($statusPay)
    {
        $this->statusPay = $statusPay;
        return $this;
    }



    /**
     * @param array $travelers
     * @return $this
     */
    public function setTravelers($travelers)
    {
        $this->travelers = $travelers;
        return $this;
    }

    /**
     * @return array
     */
    public function getTravelers()
    {
        return $this->travelers;
    }

    /**
     * @param Ticket $ticket
     * @return $this
     */
    public function setTicket(Ticket $ticket)
    {
        $this->ticket = $ticket;
        return $this;
    }

    /**
     * @return Ticket
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * @return mixed
     */
    public function getBookId()
    {
        return $this->bookId;
    }

    /**
     * @param mixed $bookId
     * @return $this
     */
    public function setBookId($bookId)
    {
        $this->bookId = $bookId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPnr()
    {
        return $this->pnr;
    }

    /**
     * @param mixed $pnr
     * @return $this
     */
    public function setPnr($pnr)
    {
        $this->pnr = $pnr;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * @param mixed $totalPrice
     * @return $this
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPnrExpireDate()
    {
        return $this->pnrExpireDate;
    }

    /**
     * @param mixed $pnrExpireDate
     * @return $this
     */
    public function setPnrExpireDate($pnrExpireDate)
    {
        $this->pnrExpireDate = $pnrExpireDate;
        return $this;
    }


}