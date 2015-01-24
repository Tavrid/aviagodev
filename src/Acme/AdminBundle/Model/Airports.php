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
                        'short' => $val->getNameShortEn()
                    ];
                } else {
                    
                    $res[$val->getCityCodeEng()][] = [
                        'country' => $val->getCountryRus(),
                        'city' => $val->getCityRus(),
                        'code' => $val->getAirportCodeEng(),
                        'airport' => $val->getAirportRus(),
                        'short' => $val->getNameShortRu()
                    ];
                }
            }
            foreach($res as $city => $airport){
                if(count($airport) > 1){
                    $f = $airport[0];
                    $r[] = array(
                        'id' => $city,
//                        'name' => $f['country'].', '.$f['city'].', Все аэропорты ('.$city.')'
                        'name' => $translator->trans('frontend.default.all_airports',[
                            'country' => $f['country'],
                            'city' => $f['city'],
                            'code' => $city
                                ])
                    );
                }
                foreach($airport as $name){
                    $r[] = array(
                        'id' => $name['code'],
                        'name' => !empty($name['short'])? $name['short']:$name['country'].', '.$name['city'].', '.$name['airport'].' ('.$name['code'].')'
                    );
                }
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
                    if($locale == 'en'){
                        return $val->getCountryEng().', '.$val->getCityEng().' ('.$code.')';
                    } else {
                        return $val->getCountryRus().', '.$val->getCityRus().' ('.$code.')';
                    }
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