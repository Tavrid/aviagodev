<?php
/**
 *
 * User: ablyakim
 * Date: 21.01.15
 * Time: 13:34
 */

namespace Bundles\DefaultBundle\Model;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;

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


    public function __construct(SessionInterface $session,RouterInterface $router){
        $this->session = $session;
        $this->router = $router;
    }

    public function addFlight($params,$isComplexSearch = false){
        if(!$isComplexSearch){
            $url = $this->router->generate('bundles_default_api_list',$params);
            $name = 'Простой поиск';
        } else {
            $url = $this->router->generate('bundles_default_search_complex_search',$params);
            $name = 'Сложный поиск';
        }
        $flights = $this->session->get(self::FLIGHT_SESSION_NAME, array());
        $flights[$url] = [
            'url' => $url,
            'name' => $name
        ];
        $this->session->set(self::FLIGHT_SESSION_NAME,array_reverse($flights));
    }

    public function getFlights(){
        return $this->session->get(self::FLIGHT_SESSION_NAME, array());
    }

} 