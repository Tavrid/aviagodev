<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 01.02.15
 * Time: 14:44
 */

namespace Bundles\ApiBundle\Api\Util;


use Bundles\ApiBundle\Api\Entity\Ticket;
use Bundles\ApiBundle\Api\Entity\Itineraries;
use Bundles\ApiBundle\Api\Entity\Segments;
use Bundles\ApiBundle\Api\Entity\Variants;

class TicketCalendarEntityCreator implements TicketEntityCreatorInterface {
    /**
     * @param $response
     * @return Ticket
     */
    public function createTicket($response)
    {

        $ticket = new Ticket();
        if(isset($response['RequestID'])){
            $ticket->setRequestId($response['RequestID']);
        }
        $ticket->setTotalPrice($response['TotalPrice']['Total'])
            ->setValidatingAirline($response['ValidatingAirline']);

        foreach($response['Itineraries'] as $inter){
            $it = new Itineraries();
            foreach($inter['Variants'] as $variants){

                $var = new Variants();
                $var->setDuration($variants['Duration'])
                    ->setVariantID($variants['VariantID']);
                $countSegments = count($variants['Segments']);
                $i = 0;
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
                        ->setMarketingAirline($segment['MarketingAirline'])
                        ->setFlightNumber($segment['FlightNumber'])
                        ->setFlightTime($segment['FlightTime'])
                        ->setDepartureTimeZone($segment['DepartureTimeZone'])
                        ->setArrivalTimeZone($segment['ArrivalTimeZone'])
                        ->setMarketingAirlineName($segment['MarketingAirlineName'])
                        ->setDepartureAirport($segment['DepartureAirport'])
                        ->setArrivalAirport($segment['ArrivalAirport'])
                        ->setAircraftName($segment['AircraftName']);

                    if($i == 0){
                        $segm->setIsFirstSegment(true);
                    }
                    $i++;
                    if($countSegments == $i){
                        $segm->setIsLastSegment(true);
                    }
                    $var->addSegment($segm);
                }

                $it->addVariant($var);
            }

            $ticket->addItineraries($it);
        }
        return $ticket;

    }


}