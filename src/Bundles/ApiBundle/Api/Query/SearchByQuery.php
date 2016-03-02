<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 31.08.14
 * Time: 19:35
 */

namespace Bundles\ApiBundle\Api\Query;

use Bundles\ApiBundle\Api\Model\AviaClassMapping;

class SearchByQuery extends QueryAbstract
{

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
        //return_way

        $paramsR = [
            'key' => $key,
                'destinations[0][departure]' => $this->params['departureCode'],
                'destinations[0][arrival]' => $this->params['arrivalCode'],
                'destinations[0][date]' => $this->params['departureDate'],
        if ($this->params['direction'] == 2) {
                'destinations[1][departure]' => $this->params['arrivalCode'],
                'destinations[1][arrival]' => $this->params['departureCode'],
                'destinations[1][date]' => $this->params['arrivalDate'],
        }
            'adt' => $this->params['adults'],
            'chd' => $this->params['children'],
            'inf' => $this->params['infant'],
            'service_class' => AviaClassMapping::getRealClassName($this->params['serviceClass']),
        ];

        return $paramsR;

    }

    /**
     * @inheritdoc
     */
    public function getApiUrl()
    {
        return 'https://v2.api.tickets.ua/avia/search.json';
    }

    /**
     * @inheritdoc
     */
    public function getKeyByParams()
    {
        $params = array_intersect_key($this->params, [
            'departureCode' => '',
            'arrivalCode' => '',
            'departureDate' => '',
            'arrivalDate' => '',
            'serviceClass' => '',
            'adults' => '',
            'children' => '',
            'infant' => '',
            ]);
        $params[] = 'AviaSearch';
        return preg_replace('/[ ]+/i', '', implode('=', $params));
    }


}