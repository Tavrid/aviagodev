<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 17.07.15
 * Time: 0:43
 */

namespace Bundles\DefaultBundle\Controller\Api;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class AirportController extends Controller
{

    public function getAirportsAction($q)
    {
        $model = $this->get('admin.city.manager');
        $resp = new JsonResponse($model->searchByToken($q));
        return $resp;
    }


}