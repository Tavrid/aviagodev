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
use Bundles\ApiBundle\Api\Model\ResponseTranslatorInterface;
use Bundles\ApiBundle\Api\Price\PriceResolverInterface;
use Bundles\ApiBundle\Api\Query\QueryAbstract;

class TicketCalendarEntityCreator implements TicketEntityCreatorInterface {

    /**
     * @var ResponseTranslatorInterface
     */
    protected $responseTranslator;
    /**
     * @var PriceResolverInterface
     */
    protected $priceResolver;

    /**
     * @param ResponseTranslatorInterface $responseTranslator
     */
    public function __construct(ResponseTranslatorInterface $responseTranslator,PriceResolverInterface $priceResolver){
        $this->responseTranslator = $responseTranslator;
        $this->priceResolver = $priceResolver;
    }

    /**
     * @inheritdoc
     */
    public function createTicket($response,QueryAbstract $query)
    {

        $ticket = new Ticket();
        if(isset($response['RequestID'])){
            $ticket->setRequestId($response['RequestID']);
        }
        if(isset($response['Travellers'])){
            $ticket->setTravelers($response['Travellers']);
        }
        $ticket->setValidatingAirline($response['ValidatingAirline']);

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
                        ->setArrivalCityName($this->responseTranslator->getCityName($segment['ArrivalCity'],$segment['ArrivalCityName']))
                        ->setArrivalCountryName($segment['ArrivalCountryName'])
                        ->setArrivalTimeZone($segment['ArrivalTimeZone'])
                        ->setArrivalDate($segment['ArrivalDate'])
                        ->setArrivalAirport($segment['ArrivalAirport'])

                        ->setDepartureCountryName($segment['DepartureCountryName'])
                        ->setDepartureCityName($this->responseTranslator->getCityName($segment['DepartureCity'],$segment['DepartureCityName']))
                        ->setDepartureAirportName($this->responseTranslator->getAirportName($segment['DepartureAirport'],$segment['DepartureAirportName']))
                        ->setDepartureDate($segment['DepartureDate'])
                        ->setDepartureTimeZone($segment['DepartureTimeZone'])
                        ->setDepartureAirport($segment['DepartureAirport'])

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

        $this->priceResolver->resolve($ticket, $query,$response);
        return $ticket;

    }


}