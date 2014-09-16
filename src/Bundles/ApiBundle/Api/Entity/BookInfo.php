<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 14.09.14
 * Time: 17:17
 */

namespace Bundles\ApiBundle\Api\Entity;


class BookInfo {
    /**
     * @var \Bundles\ApiBundle\Api\Entity\Ticket
     */
    protected $ticket;
    /**
     * @var string
     */
    protected $bookId;
    /**
     * @var array
     */
    protected $travelers;

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
     * @param string $bookId
     */
    public function setBookId($bookId)
    {
        $this->bookId = $bookId;
    }

    /**
     * @return string
     */
    public function getBookId()
    {
        return $this->bookId;
    }

    /**
     * @param Ticket $ticket
     * @return $this
     */
    public function setTicket(\Bundles\ApiBundle\Api\Entity\Ticket $ticket)
    {
        $this->ticket = $ticket;
        return $this;
    }

    /**
     * @return \Bundles\ApiBundle\Api\Entity\Ticket
     */
    public function getTicket()
    {
        return $this->ticket;
    }


} 