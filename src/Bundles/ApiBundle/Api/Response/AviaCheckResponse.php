<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 01.09.14
 * Time: 20:18
 */

namespace Bundles\ApiBundle\Api\Response;

use Bundles\ApiBundle\Api\Entity\AviaCheck;

use Bundles\ApiBundle\Api\Query\QueryAbstract;
use Bundles\ApiBundle\Api\EntityCreator\TicketEntityCreatorInterface;


class AviaCheckResponse extends Response {
    /**
     * @var TicketEntityCreatorInterface
     */
    protected $ticketCreator;
    /**
     * @var QueryAbstract
     */
    protected $query;

    /**
     * @param TicketEntityCreatorInterface $ticketCreator
     * @param QueryAbstract $query
     */
    public function __construct(TicketEntityCreatorInterface $ticketCreator,QueryAbstract $query = null){
        $this->ticketCreator = $ticketCreator;
        $this->query = $query;
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
            ->setStatusPay($data['StatusPay']);
        $price = $this->ticketCreator->getPriceResolver()
            ->resolve($data,$this->query);
        $entity->setTotalPrice($price['price']['Total']);
        $ticket = $this->ticketCreator->createTicket($data,$this->query);

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