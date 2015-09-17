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

class SettingsController extends Controller
{
    /**
     * @param $locale
     * @return JsonResponse
     */
    public function getChangeLocaleAction($locale)
    {
        $this->get('session')->set('_locale', $locale);
        return new JsonResponse();
    }


}