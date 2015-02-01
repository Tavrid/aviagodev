<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 31.08.14
 * Time: 19:35
 */

namespace Bundles\ApiBundle\Api\Query;

use Bundles\ApiBundle\Api\Model\AviaClassMapping;

class AviaCheck extends QueryAbstract {

    protected $params;

    /**
     * @param $params
     * @return $this
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @inheritdoc
     */
    public function buildParams($key)
    {

        $paramsR = [
            'jsonrpc' => '2.0',
            'id' => 1,
            'method' => 'AviaCheck',
            'params' => [
                [
                    'Type' => 'Site',
                    'System' => 'Agent',
                    'Key' => $key,
                    'UserIP' => '127.0.0.1',
                    'UserUUID' => ''
                ],
                [
                    'PNR' => $this->params['pnr'],
                    'Surname' =>$this->params['surname'],


                ],
                [
                    'Compress' => null,
                    'Format' => 'Combined',
                    'Return' => '',
//                    'Return' => 'ByTimelimit',
                    'Currency' => array('RUB','USD','EUR'),

                    'Language' => 'RU'
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