<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 17.06.15
 * Time: 14:25
 */

namespace Bundles\YandexAviaBundle\Model;


use Bundles\ApiBundle\Api\Entity\Segments;
use Bundles\ApiBundle\Api\Entity\Ticket;
use Bundles\ApiBundle\Api\Response\SearchResponse;
use Symfony\Component\Routing\RouterInterface;

class RoutesGenerator
{

    protected $router;

    /**
     *
     */
    public function __construct(RouterInterface $route)
    {
        $this->router = $route;
    }

    /**
     * @param SearchResponse $response
     */
    public function generate(SearchResponse $response)
    {
        $xml = new \DOMDocument("1.0", "utf-8");
        $root = $xml->createElement('variants');
        /** @var Ticket $ticket */
        foreach ($response as $ticket) {
            $itineraries = $ticket->getItineraries();
            if (count($itineraries) == 1) {
            } else if (count($itineraries) == 2) {
                foreach ($itineraries[0]->getVariants() as $variantForward) {
                    foreach ($itineraries[1]->getVariants() as $variantBackward) {

                        $variant = $xml->createElement('variant');
                        $variant->setAttribute('url', uniqid());
                        foreach ($variantForward->getSegments() as $segment) {
                            $route = $xml->createElement('route_forward');
                            $this->createRouteAttributes($route, $segment);
                            $variant->appendChild($route);
                        }
                        foreach ($variantBackward->getSegments() as $segment) {
                            $route = $xml->createElement('route_backward');
                            $this->createRouteAttributes($route, $segment);
                            $variant->appendChild($route);

                        }

                        $root->appendChild($variant);
                    }
                }

            } else {
                return null;
            }

        }
        $xml->appendChild($root);
        return $xml->saveXML();
    }

    /**
     *  route_code = "0123АБ"                     // номер рейса
     * company_code = "BL"                       // код авиакомпании
     * company_name = "Blah-air"                 // название авиакомпании
     * departure_airport_code = "DME"            // код аэропорта отправления
     * departure_airport_name = "Домодедово"     // название аэропорта отправления
     * arrival_airport_code = "SVO"              // код аэропорта назначения
     * arrival_airport_name = "Кольцово"         // название аэропорта назначения
     * departure_datetime = "2011-04-01 18:12"   // дата-время отправления (локальное время)
     * arrival_datetime = "2011-04-01 21:20"     // дата-время прибытия (локальное время)
     * route_time = "123"
     */
    protected function createRouteAttributes(\DOMElement $document, Segments $segment)
    {
        $document->setAttribute('route_code', $segment->getFlightNumber());
        $document->setAttribute('company_code', $segment->getMarketingAirline());
        $document->setAttribute('company_name', $segment->getMarketingAirlineName());
        $document->setAttribute('departure_airport_code', $segment->getDepartureAirport());
        $document->setAttribute('departure_airport_name', $segment->getDepartureAirportName());
        $document->setAttribute('arrival_airport_code', $segment->getArrivalAirport());
        $document->setAttribute('arrival_airport_name', $segment->getArrivalAirportName());
        $document->setAttribute('departure_datetime', date('Y-m-d H:i', $segment->getDepartureDate()));
        $document->setAttribute('arrival_datetime', date('Y-m-d H:i', $segment->getArrivalDate()));
        $document->setAttribute('route_time', $segment->getFlightTime());
    }

    /**
     * <fare
     * seats = "14"                              // свободные места в данном классе обслуживания
     * value = "123.45"                          // цена (минимальная цена) в данном классе обслуживания
     * class = "E"                             // код класса обслуживания
     * />
     */
    protected function createFare(\DOMElement $document)
    {

    }

}