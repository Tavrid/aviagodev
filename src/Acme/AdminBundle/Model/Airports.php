<?php


namespace Acme\AdminBundle\Model;
use Acme\CoreBundle\Model\AbstractModel;

class Airports extends AbstractModel {

    public function searchByToken($token){
        $locale = $this->container->get('request')->getLocale();
        /* @var $translator \Symfony\Component\Translation\TranslatorInterface */
        $translator = $this->container->get('translator');
        
        $res = array();
        $r = array();
        /* @var $d \Acme\AdminBundle\Entity\AviaAirports[] */
        $d =  $this->getRepository()
            ->createQuery(array('searchByToken' => array($token)))
            ->getResult();

        if($d){
            
            foreach ($d as $val){
                if($locale == 'en'){
                    
                    $res[$val->getCityCodeEng()][] = [
                        'country' => $val->getCountryEng(),
                        'city' => $val->getCityEng(),
                        'code' => $val->getAirportCodeEng(),
                        'airport' => $val->getAirportEng(),
                        'short' => $val->getNameShortEn(),
                        'formatted' => $val->getFormattedName($locale)
                    ];
                } else {
                    
                    $res[$val->getCityCodeEng()][] = [
                        'country' => $val->getCountryRus(),
                        'city' => $val->getCityRus(),
                        'code' => $val->getAirportCodeEng(),
                        'airport' => $val->getAirportRus(),
                        'short' => $val->getNameShortRu(),
                        'formatted' => $val->getFormattedName($locale)
                    ];
                }
            }

            foreach($res as $city => $airport){
                $f = $airport[0];
                $tempVal = array(
                    'id' => $city,
                    'name' => $f['city'],
                    'country' => $f['country'],
                    'airport' => $f['airport'],
                    'code' => $f['code'],
                    'formatted' => $f['formatted'],
                );
                if(count($airport) > 1){
                    foreach($airport as $name){
                        $tempVal['child'][] = array(
                            'id' => $name['code'],
                            'country' => $name['country'],
                            'airport' => $name['airport'],
                            'code' => $name['code'],
                            'name' => !empty($name['short'])? $name['short']:$name['city'],
                            'formatted' => $name['formatted'],
                        );
                    }
                }
                $r[] = $tempVal;
            }
        }
        return $r;
    }

    public function getFormattedNameByIata($code){
        $locale = $this->container->get('request')->getLocale();
        /* @var $results \Acme\AdminBundle\Entity\AviaAirports[]  */
        $results = $this->getRepository()
            ->createQuery(['getByCode' => $code])->getResult();

        if($results){
            foreach($results as $val){
                if($code == $val->getCityCodeEng() ||  $code == $val->getAirportCodeEng()){
                   return $val->getFormattedName($locale);
                }
            }
        }
        return null;
    }

    public function listItemsShowHidden($page = 1,$params = []){
        $qb = $this->getRepository()
            ->createQueryBuilder('p');
        $qb ->orderBy('p.regionRus')
            ->where($qb->expr()->andX(
                $qb->expr()->like('p.airportCodeEng', $qb->expr()->literal('%'.$params['airport_code'].'%')),
                $qb->expr()->like('p.cityCodeEng', $qb->expr()->literal('%'.$params['city_code'].'%')),
                $qb->expr()->like('p.cityRus', $qb->expr()->literal('%'.$params['city_name'].'%')),
                $qb->expr()->like('p.countryRus', $qb->expr()->literal('%'.$params['country_name'].'%'))
//                $qb->expr()->like('p.cityRus', $qb->expr()->literal('%sip%'))

            ));
        $extPar = is_array($_GET) ? $_GET : [];
        return $this->paginator($page, $qb, 'admin.aviaairports.index', 20,$extPar);
    }

} 