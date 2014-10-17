<?php

/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 22.09.14
 * Time: 21:21
 */

namespace Bundles\ApiBundle\Api\Filter;

use Bundles\ApiBundle\Api\Entity\Ticket;

class DirectFlightsFilter extends Filter {

    protected $directFlights;

    public function __construct($directFlights) {
        $this->directFlights = $directFlights;
    }

    public function filterItem(Ticket &$ticket) {
        if ($this->directFlights) {
            $variants = $ticket->getFirstItinerarie()->getVariants();

            foreach ($variants as $k => $variant) {
                if (count($variant->getSegments()) > 1) {
                    unset($variants[$k]);
                }
            }

            if (!empty($variants)) {
                $ticket->getFirstItinerarie()->setVariants($variants);
                return true;
            } else {
                return false;
            }
        }

        return true;
    }

}
