<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 22.09.14
 * Time: 21:21
 */
namespace Bundles\ApiBundle\Api\Filter;

use Bundles\ApiBundle\Api\Entity\Ticket;
use Bundles\ApiBundle\Api\Filter\Time;

class DepartureTimeFilter extends Filter {

    /**
     * @var array
     */
    protected $params;

    public function __construct($params){
        $this->params = $params;
    }

    public function filterItem(Ticket &$ticket)
    {
        if(empty($this->params)){
            return true;
        }

        $variants = $ticket->getFirstItinerarie()->getVariants();
        foreach ($variants as $k => $variant) {
            $success = false;
            $d = $variant->getDepartureSegment()->getDepartureDate();
            foreach($this->params as $par){
                if(Time::isValidTime($d,$par)){
                    $success = true;
                    break;
                }
            }
            if(!$success){
                unset($variants[$k]);
            }
        }
        $ticket->getFirstItinerarie()->setVariants($variants);


        return (bool) count($variants);
    }


}