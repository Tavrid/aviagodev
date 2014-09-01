<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 01.09.14
 * Time: 20:00
 */

namespace Bundles\ApiBundle\Api\Request;
use Bundles\ApiBundle\Api\Query\QueryAbstract;
use Bundles\ApiBundle\Api\Response\Response;


Interface Request {
    /**
     * @param QueryAbstract $query
     * @return Response
     */
    public function execute(QueryAbstract $query);

} 