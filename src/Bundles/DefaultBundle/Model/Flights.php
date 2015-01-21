<?php
/**
 *
 * User: ablyakim
 * Date: 21.01.15
 * Time: 13:34
 */

namespace Bundles\DefaultBundle\Model;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Flights {
    const FLIGHT_SESSION_NAME = 'flights';
    /**
     * @var SessionInterface
     */
    protected $session;


    public function __construct(SessionInterface $session){
        $this->session = $session;
    }

    public function addFlight($name,$url){
        $flights = $this->session->get(self::FLIGHT_SESSION_NAME, array());
        $flights[$url] = [
            'url' => $url,
            'name' => $name
        ];
        $this->session->set(self::FLIGHT_SESSION_NAME,array_reverse($flights));
    }

    public function getFlights(){

    }

} 