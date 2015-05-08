<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 08.05.15
 * Time: 12:04
 */

namespace Bundles\DefaultBundle\Util;
use Symfony\Component\HttpFoundation\RequestStack;

class ControllerFormatter {

    protected $requestStack;
    public function __construct(RequestStack $requestStack){
        $this->requestStack = $requestStack;
    }

    /**
     * @return mixed|string
     */
    public function getFormattedName()
    {
        $str = '';
        $request = $this->requestStack->getCurrentRequest();
        if($request){
            $controller = $request->get('_controller');
            $str = preg_replace('/.+\\\([A-Za-z]+?)Controller:{2}([A-Za-z]+?)Action/i','$1-$2',$controller);
            $str = strtolower($str);
        }
        return $str;
    }

}