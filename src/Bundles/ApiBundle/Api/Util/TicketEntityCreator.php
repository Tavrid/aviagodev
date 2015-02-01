<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 01.02.15
 * Time: 14:22
 */

namespace Bundles\ApiBundle\Api\Util;


use Bundles\ApiBundle\Api\Entity\Ticket;
use Bundles\ApiBundle\Api\Entity\Itineraries;
use Bundles\ApiBundle\Api\Entity\Segments;
use Bundles\ApiBundle\Api\Entity\Variants;

class TicketEntityCreator implements TicketEntityCreatorInterface {
    /**
     * @inheritdoc
     */
    public function createTicket($response)
    {
        $ticket = new Ticket();
        $ticket->setRequestId($response['RequestID'])
            ->setTotalPrice($response['TotalPrice']['Total'])
            ->setPricing($response['Pricing'])
            ->setTravelers($response['Travellers']);
        if(isset($response['Refundable'])){
            $ticket->setRefundable($response['Refundable']);
        }
        if(isset($response['Surnames'])){
            $ticket->setSurnames($response['Surnames']);
        }
        if(isset($response['LatinRegistration'])){
            $ticket->setLatinRegistration($response['LatinRegistration']);
        }
        foreach($response['Itineraries'] as $variants){
            $it = new Itineraries();
            $var = new Variants();
            $var->setDuration($variants['Duration'])
                ->setVariantID($variants['VariantID']);
            foreach($variants['Segments'] as $segment){
                $segm = new Segments();
                $segm->setArrivalAirportName($segment['ArrivalAirportName'])
                    ->setArrivalCountryName($segment['ArrivalCountryName'])
                    ->setArrivalCityName($segment['ArrivalCityName'])
                    ->setArrivalDate($segment['ArrivalDate'])
                    ->setDepartureCountryName($segment['DepartureCountryName'])
                    ->setDepartureCityName($segment['DepartureCityName'])
                    ->setDepartureAirportName($segment['DepartureAirportName'])
                    ->setDepartureDate($segment['DepartureDate'])
                    ->setAvailableSeats($segment['AvailableSeats'])
                    ->setArrivalCity($segment['ArrivalCity'])
                    ->setDepartureCity($segment['DepartureCity'])
                ;
                $var->addSegment($segm);
            }
            $it->addVariant($var);
            $ticket->addItineraries($it);
        }
        return $ticket;
    }


}