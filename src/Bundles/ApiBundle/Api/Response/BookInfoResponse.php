<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 01.09.14
 * Time: 20:18
 */

namespace Bundles\ApiBundle\Api\Response;

use Bundles\ApiBundle\Api\Entity\BookInfo;


use Bundles\ApiBundle\Api\Entity\Ticket;
use Bundles\ApiBundle\Api\Entity\Itineraries;
use Bundles\ApiBundle\Api\Entity\Segments;
use Bundles\ApiBundle\Api\Entity\Variants;



class BookInfoResponse extends Response {

    protected $entity;

    protected function createEntity(){
        $data = $this->response['result'];
        $requestId = $data['RequestID'];;
        $entity = new BookInfo();
        $entity->setTravelers($data['Travellers']);

        $ticket = new Ticket();
        $ticket->setRequestId($requestId)
            ->setTotalPrice($data['TotalPrice']['Total'])
            ->setPricing($data['Pricing'])
            ->setTravelers($data['Travellers']);
        if(isset($data['LatinRegistration'])){
            $ticket->setLatinRegistration($data['LatinRegistration']);
        }
        foreach($data['Itineraries'] as $variants){
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
                        ->setAvailableSeats($segment['AvailableSeats']);
                    $var->addSegment($segm);
                }
                $it->addVariant($var);
            $ticket->addItineraries($it);
        }
        $entity->setTicket($ticket)
            ->setBookId($data['BookID']);
        $this->entity = $entity;
    }

    /**
     * @return BookInfo
     */

    public function getEntity(){
        if(!$this->entity){
            $this->createEntity();
        }
        return $this->entity;
    }




}