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
use Symfony\Component\Translation\TranslatorInterface;

class SecondsToTime extends \Twig_Extension
{
    protected $translator;
    public function __construct(TranslatorInterface $translator){
        $this->translator = $translator;
    }

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
                $params['%d%'] = $this->translator->trans('seconds_to_time.format.days', ['%num%' => $days]);
            }

            if($seconds>=60*60){
                $hours = floor($seconds/(60*60));
                $seconds -= $hours*(60*60);
                $params['%h%'] = $this->translator->trans('seconds_to_time.format.hours', ['%num%' => $hours]);
            }

            if($seconds>=60){
                $min = floor($seconds/60);
                $seconds -= $min*60;
                $params['%m%'] = $this->translator->trans('seconds_to_time.format.minutes', ['%num%' => $min]);
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