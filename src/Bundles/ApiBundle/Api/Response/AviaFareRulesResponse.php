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



class AviaFareRulesResponse extends Response {

    public function getFareRules(){
        return isset($this->response['result']['FareRules']) ? $this->response['result']['FareRules'] :  null;
    }




}