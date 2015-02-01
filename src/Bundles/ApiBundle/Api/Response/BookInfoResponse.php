<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 01.09.14
 * Time: 20:18
 */

namespace Bundles\ApiBundle\Api\Response;

use Bundles\ApiBundle\Api\Entity\BookInfo;


use Bundles\ApiBundle\Api\Entity\Ticket;
use Bundles\ApiBundle\Api\Entity\Itineraries;
use Bundles\ApiBundle\Api\Entity\Segments;
use Bundles\ApiBundle\Api\Entity\Variants;
use Bundles\ApiBundle\Api\Util\TicketEntityCreatorInterface;


class BookInfoResponse extends Response {

    /**
     * @var TicketEntityCreatorInterface
     */
    protected $ticketCreator;

    public function __construct(TicketEntityCreatorInterface $ticketCreator){
        $this->ticketCreator = $ticketCreator;
    }

    protected $entity;

    protected function createEntity(){
        if(!isset($this->response['result'])){
            return;
        }
        $data = $this->response['result'];
        $entity = new BookInfo();
        $entity->setTravelers($data['Travellers']);

        $ticket = $this->ticketCreator->createTicket($data);
        $entity->setTicket($ticket)
            ->setBookId($data['BookID']);
        $this->entity = $entity;
    }

    /**
     * @return BookInfo
     */

    public function getEntity(){
        if(!$this->entity){
            $this->createEntity();
        }
        return $this->entity;
    }




}