<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 08.09.14
 * Time: 23:15
 */

namespace Bundles\DefaultBundle\Response;

use Symfony\Component\HttpFoundation\Response;


class AjaxSearchResponse extends Response {

    public function __construct($redirectUrl, $status = 200, $headers = array())
    {

        $headers = array_replace(['Content-Type' => 'application/json'],$headers);
        $content = json_encode(['url' => $redirectUrl]);
        parent::__construct($content, $status, $headers);
    }

} 