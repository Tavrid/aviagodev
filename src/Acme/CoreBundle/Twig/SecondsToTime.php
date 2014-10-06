<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 7/5/13
 * Time: 11:08 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Acme\CoreBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

class SecondsToTime extends \Twig_Extension
{


    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('secondToTime', array($this, 'secondToTime')),
        );
    }

    public function secondToTime($seconds)
    {

        if($seconds){
            $params = [
                '%d%' => '',
                '%h%' => '',
                '%m%' => '',
            ];
            if($seconds >= (60*60*24)){
                $days = floor($seconds/(60*60*24));
                $seconds -= $days*(60*60*24);
                $params['%d%'] = $days.' д.';
            }

            if($seconds>=60*60){
                $hours = floor($seconds/(60*60));
                $seconds -= $hours*(60*60);
                $params['%h%'] = ' '.$hours.' ч.';
            }

            if($seconds>=60){
                $min = floor($seconds/60);
                $seconds -= $min*60;
                $params['%m%'] = ' '.$min.' мин.';
            }

            return str_replace(array_keys($params),$params,'%d%%h%%m%');
        } else {
            return 0;
        }
    }

    public function getName()
    {
        return 'seconds_to_time_extension';
    }

}