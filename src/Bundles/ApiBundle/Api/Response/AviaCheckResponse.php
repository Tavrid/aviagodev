<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 01.09.14
 * Time: 20:18
 */

namespace Bundles\ApiBundle\Api\Response;

use Bundles\ApiBundle\Api\Entity\AviaCheck;
use Bundles\ApiBundle\Api\Entity\BookInfo;


use Bundles\ApiBundle\Api\Entity\Ticket;
use Bundles\ApiBundle\Api\Entity\Itineraries;
use Bundles\ApiBundle\Api\Entity\Segments;
use Bundles\ApiBundle\Api\Entity\Variants;
use Bundles\ApiBundle\Api\Util\TicketEntityCreatorInterface;


class AviaCheckResponse extends Response {
    /**
     * @var TicketEntityCreatorInterface
     */
    protected $ticketCreator;

    public function __construct(TicketEntityCreatorInterface $ticketCreator){
        $this->ticketCreator = $ticketCreator;
    }

    public function getPnr() {
        return $this->response['result']['PNR'];
    }

    protected $entity;

    protected function createEntity(){
        if(!isset($this->response['result'])){
            return;
        }
        $data = $this->response['result'];
        $entity = new AviaCheck();
        $entity->setTravelers($data['Travellers'])
            ->setBookId($data['BookID'])
            ->setPnr($data['PNR'])
            ->setPnrExpireDate($data['PNRExpireDate'])
            ->setTotalPrice($data['TotalPrice'])
            ->setStatusPay($data['StatusPay']);

        $ticket = $this->ticketCreator->createTicket($data);

        $entity->setTicket($ticket)
            ->setBookId($data['BookID']);
        $this->entity = $entity;
    }

    /**
     * @return AviaCheck
     */

    public function getEntity(){
        if(!$this->entity){
            $this->createEntity();
        }
        return $this->entity;
    }
}