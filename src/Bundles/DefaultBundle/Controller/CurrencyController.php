<?php

namespace Bundles\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CurrencyController extends Controller
{
    public function indexAction($currency)
    {
        $this->get('bundle_default.currency_manager')->setCurrency($currency);
        return new Response('Ok');
    }
}