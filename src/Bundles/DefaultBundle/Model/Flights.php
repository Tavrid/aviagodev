<?php
/**
 *
 * User: ablyakim
 * Date: 21.01.15
 * Time: 13:34
 */

namespace Bundles\DefaultBundle\Model;

use Bundles\DefaultBundle\Util\RouteParams;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Acme\AdminBundle\Model\Airports;

class Flights {
    const FLIGHT_SESSION_NAME = 'flights';
    /**
     * @var SessionInterface
     */
    protected $session;
    /**
     * @var RouterInterface
     */
    protected $router;
    /**
     * @var RouteParams
     */
    protected $routeParams;
    /**
     * @var TranslatorInterface
     */
    protected $translator;
    /**
     * @var Airports
     */
    protected $airports;

    public function __construct(SessionInterface $session,
                                RouterInterface $router,
                                RouteParams $routeParams,
                                TranslatorInterface $translator,
                                Airports $airports){
        $this->session = $session;
        $this->router = $router;
        $this->routeParams = $routeParams;
        $this->translator = $translator;
        $this->airports = $airports;
    }

    public function addFlight($params,$isComplexSearch = false){
        if(!$isComplexSearch){
            $url = $this->router->generate('bundles_default_api_list',$params);
            $cityFrom = $this->airports->getFormattedNameByIata($params['city_from_code']);
            $cityTo = isset($params['city_to_code']) ? $this->airports->getFormattedNameByIata($params['city_to_code']) : '';
            $name = $this->translator->trans('frontend.flights.simple_name',['%cityFrom%' =>$cityFrom,'%cityTo%' => $cityTo ]);
        } else {

            $url = $this->router->generate('bundles_default_search_complex_search',$params);
            $paramsResolved = $this->routeParams->resolveParams($params);
            $cityFrom = current($paramsResolved['complexFields'])['cityFrom'];
            $cityTo = end($paramsResolved['complexFields'])['cityTo'];
            $name = $this->translator->trans('frontend.flights.complex_name',['%cityFrom%' =>$cityFrom,'%cityTo%' => $cityTo ]);
        }
        $flights = $this->session->get(self::FLIGHT_SESSION_NAME, array());
        $flights[$url] = [
            'url' => $url,
            'name' => $name
        ];
        $this->session->set(self::FLIGHT_SESSION_NAME,array_reverse($flights));
    }

    public function getFlights(){
        return array_slice($this->session->get(self::FLIGHT_SESSION_NAME, array()),0,5);
    }

} 