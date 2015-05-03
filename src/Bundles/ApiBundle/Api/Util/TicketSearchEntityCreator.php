<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 01.02.15
 * Time: 15:18
 */

namespace Bundles\ApiBundle\Api\Util;


use Bundles\ApiBundle\Api\Entity\Ticket;
use Bundles\ApiBundle\Api\Entity\Itineraries;
use Bundles\ApiBundle\Api\Entity\Segments;
use Bundles\ApiBundle\Api\Entity\Variants;
use Bundles\ApiBundle\Api\Model\ResponseTranslatorInterface;

class TicketSearchEntityCreator implements TicketEntityCreatorInterface {
    /**
     * @var ResponseTranslatorInterface
     */
    protected $responseTranslator;

    /**
     * @param ResponseTranslatorInterface $responseTranslator
     */
    public function __construct(ResponseTranslatorInterface $responseTranslator){
        $this->responseTranslator = $responseTranslator;
    }
    /**
     * @param $response
     * @return Ticket
     */
    public function createTicket($response)
    {

        $ticket = new Ticket();
        $ticket->setRequestId($response['RequestID']);
        $ticket->setTotalPrice($response['TotalPrice']['Total'])
            ->setValidatingAirline($response['ValidatingAirline'])
            ->setLastTicketDate($response['LastTicketDate'])
            ->setRefundable($response['Refundable']);

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
                    $segm->setArrivalAirportName($this->responseTranslator->getAirportName($segment['ArrivalAirport'],$segment['ArrivalAirportName']))
                        ->setArrivalCountryName($segment['ArrivalCountryName'])
                        ->setArrivalCityName($this->responseTranslator->getCityName($segment['ArrivalCity'],$segment['ArrivalCityName']))
                        ->setArrivalDate($segment['ArrivalDate'])
                        ->setArrivalTimeZone($segment['ArrivalTimeZone'])
                        ->setArrivalAirport($segment['ArrivalAirport'])
                        ->setArrivalTerminal($segment['DepartureTerminal'])

                        ->setDepartureCountryName($segment['DepartureCountryName'])
                        ->setDepartureCityName($this->responseTranslator->getCityName($segment['DepartureCity'],$segment['DepartureCityName']))
                        ->setDepartureAirportName($this->responseTranslator->getAirportName($segment['DepartureAirport'],$segment['DepartureAirportName']))
                        ->setDepartureDate($segment['DepartureDate'])
                        ->setDepartureTimeZone($segment['DepartureTimeZone'])
                        ->setDepartureAirport($segment['DepartureAirport'])
                        ->setDepartureTerminal($segment['ArrivalTerminal'])

                        ->setAvailableSeats($segment['AvailableSeats'])
                        ->setMarketingAirline($segment['MarketingAirline'])
                        ->setFlightNumber($segment['FlightNumber'])
                        ->setFlightTime($segment['FlightTime'])
                        ->setMarketingAirlineName($segment['MarketingAirlineName'])
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