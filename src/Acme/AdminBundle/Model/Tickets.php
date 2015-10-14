<?php


namespace Acme\AdminBundle\Model;


use Acme\CoreBundle\Model\AbstractModel;
use Acme\CoreBundle\Model\ArraySlice;

class Tickets extends AbstractModel
{
    public function getTickets()
    {
        $res = [];
        $tickets = $this->getRepository()->findBy(['type' => 1,'isEnabled'=>true]);
        if($tickets){
            $res = ArraySlice::slice($tickets,5);
        }
        return $res;
    }
}