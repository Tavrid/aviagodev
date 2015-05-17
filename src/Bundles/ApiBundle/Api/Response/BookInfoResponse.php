<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 01.09.14
 * Time: 20:18
 */

namespace Bundles\ApiBundle\Api\Response;

use Bundles\ApiBundle\Api\Entity\BookInfo;
use Bundles\ApiBundle\Api\Query\QueryAbstract;
use Bundles\ApiBundle\Api\EntityCreator\TicketEntityCreatorInterface;


class BookInfoResponse extends Response {

    /**
     * @var TicketEntityCreatorInterface
     */
    protected $ticketCreator;
    /**
     * @var
     */
    protected $entity;
    /**
     * @var QueryAbstract
     */
    protected $query;

    public function __construct(TicketEntityCreatorInterface $ticketCreator,QueryAbstract $query){
        $this->ticketCreator = $ticketCreator;
        $this->query = $query;
    }


    protected function createEntity(){
        if(!isset($this->response['result'])){
            return;
        }
        $data = $this->response['result'];
        $entity = new BookInfo();
        $entity->setTravelers($data['Travellers']);

        $ticket = $this->ticketCreator->createTicket($data,$this->query);
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