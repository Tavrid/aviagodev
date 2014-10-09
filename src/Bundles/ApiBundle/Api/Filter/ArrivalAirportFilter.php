<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 22.09.14
 * Time: 21:21
 */
namespace Bundles\ApiBundle\Api\Filter;

use Bundles\ApiBundle\Api\Entity\Ticket;

class ArrivalAirportFilter extends Filter {


    protected $airport;

    public function __construct($airport){
        $this->airport = $airport;
    }

    public function filterItem(Ticket &$ticket)
    {
        if(!$this->airport){
            return true;
        }
        $variants = $ticket->getFirstItinerarie()->getVariants();

        foreach($variants as $k => $variant){
            $segment = $variant->getArrivalSegment();
            $variant->setDuration(0);
            if($segment->getArrivalAirport() != $this->airport){
                unset($variants[$k]);
            }
        }

        if(!empty($variants)){
            $ticket->getFirstItinerarie()->setVariants($variants);
            return true;
        } else {
            return false;
        }

    }

}