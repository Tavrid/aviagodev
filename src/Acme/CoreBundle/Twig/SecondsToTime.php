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
//        return $seconds;
        if($seconds){
            $days = 0;
            $hours = 0;
            $min = 0;
            if($seconds >= (60*60*24)){
                $days = floor($seconds/(60*60*24));
                $seconds -= $days*(60*60*24);
            }

            if($seconds>=60*60){
                $hours = floor($seconds/(60*60));
                $seconds -= $hours*(60*60);
            }

            if($seconds>=60){
                $min = floor($seconds/60);
                $seconds -= $min*60;
            }
            if($days){
                return sprintf('%d д. %d ч. %d мин.',$days,$hours,$min);
            } else if($hours){
                return sprintf('%d ч. %d мин.',$hours,$min);
            } else {
                return sprintf('%d мин.',$min);

            }


        } else {
            return 0;
        }
    }

    public function getName()
    {
        return 'seconds_to_time_extension';
    }

}