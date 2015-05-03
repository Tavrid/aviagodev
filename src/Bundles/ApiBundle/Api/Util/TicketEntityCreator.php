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
use Bundles\ApiBundle\Api\Model\ResponseTranslatorInterface;

class TicketEntityCreator implements TicketEntityCreatorInterface {

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
     * @inheritdoc
     */
    public function createTicket($response)
    {
        $ticket = new Ticket();
        $ticket->setRequestId($response['RequestID'])
            ->setTotalPrice($response['TotalPrice']['Total'])
            ->setPricing($response['Pricing'])
            ->setTravelers($response['Travellers']);
        if(isset($response['PNRExpireDate'])){
            $ticket->setPNRExpireDate($response['PNRExpireDate']);
        }
        if(isset($response['LastTicketDate'])){
            $ticket->setLastTicketDate($response['LastTicketDate']);
        }

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
                $segm->setArrivalAirportName($this->responseTranslator->getAirportName($segment['ArrivalAirport'],$segment['ArrivalAirportName']))
                    ->setArrivalCountryName($segment['ArrivalCountryName'])
                    ->setArrivalCityName($this->responseTranslator->getCityName($segment['ArrivalCity'],$segment['ArrivalCityName']))
                    ->setArrivalCity($segment['ArrivalCity'])
                    ->setArrivalDate($segment['ArrivalDate'])

                    ->setDepartureCountryName($segment['DepartureCountryName'])
                    ->setDepartureCityName($this->responseTranslator->getCityName($segment['DepartureCity'],$segment['DepartureCityName']))
                    ->setDepartureAirportName($this->responseTranslator->getAirportName($segment['DepartureAirport'],$segment['DepartureAirportName']))
                    ->setDepartureDate($segment['DepartureDate'])
                    ->setDepartureCity($segment['DepartureCity'])

                    ->setAvailableSeats($segment['AvailableSeats'])
                    ->setFlightNumber($segment['FlightNumber'])
                    ->setFlightTime($segment['FlightTime'])
                    ->setMarketingAirline($segment['MarketingAirline'])
                    ->setMarketingAirlineName($segment['MarketingAirlineName'])
                ;
                $var->addSegment($segm);
            }
            $it->addVariant($var);
            $ticket->addItineraries($it);
        }
        return $ticket;
    }


}