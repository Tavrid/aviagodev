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


class BookInfoResponse extends Response {

    protected $entity;

    protected function createEntity(){
        $data = $this->response['result'];
        $requestId = $this->response['result']['RequestID'];;
        $entity = new BookInfo();
        $ticket = new Ticket();
        $ticket->setRequestId($requestId);
        $entity->setTicket($ticket)
        ->setBookId($data['BookID']);

        $this->entity = $entity;
    }

    public function getEntity(){
        if(!$this->entity){
            $this->createEntity();
        }
        return $this->entity;
    }




}