<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 31.08.14
 * Time: 19:35
 */

namespace Bundles\ApiBundle\Api\Query;

use Bundles\ApiBundle\Api\Model\AviaClassMapping;

class BookQuery extends QueryAbstract {



    /**
     * @inheritdoc
     */
    public function buildParams($key)
    {
        $paramsR = [
            'jsonrpc' => '2.0',
            'id' => 1,
            'method' => 'AviaBook',
            'params' => [
                [
                    'Type' => 'Site',
                    'System' => 'Agent',
                    'Key' => $key,
                    'UserIP' => '127.0.0.1',
                    'UserUUID' => ''
                ],
                [
                    'BookID'		=> $this->params['bookID'],
                    'Travellers'	=> $this->params['travellers'],
                    'Contacts'		=> $this->params['contacts'],


                ],
                [
                    'Compress'		=> '',
                    'Format'		=> 'Combined',
                    'Return'		=> 'ByTimelimit',
                    'Language'		=> 'RU',
                    'Currency'		=> array('RUB','USD','EUR','UAH'),
                    'Timelimit'		=> 180,
                ]
            ]
        ];
        return $paramsR;

    }

    public function getApiUrl(){
        return 'http://ws.demo.webservices.aero/';
    }

    public function getKeyByParams()
    {
        return null;
    }


}