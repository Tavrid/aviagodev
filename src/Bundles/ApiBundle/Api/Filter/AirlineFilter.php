<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 22.09.14
 * Time: 21:21
 */
namespace Bundles\ApiBundle\Api\Filter;

use Bundles\ApiBundle\Api\Entity\Ticket;

class AirlineFilter extends Filter {


    protected $airline;

    public function __construct($airline){
        $this->airline = $airline;
        if(!is_array($this->airline)){
            $this->airline = [];
        }
    }

    public function filterItem(Ticket &$ticket)
    {
        if($this->airline){
            if(!in_array('all',$this->airline)){
                return in_array($ticket->getValidatingAirline(),$this->airline);
            }
        }

        return true;
    }


}