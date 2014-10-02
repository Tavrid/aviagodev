<?php


namespace Acme\AdminBundle\Repository;
use Acme\CoreBundle\Repository\AbstractRepository;

class CityRepository extends AbstractRepository {

    public function searchByToken($token){

        $token = '%'.$token.'%';
        $searchFields = array(
            'iata_code',
            'name_rus',
            'name_eng',
            'city_rus',
            'city_eng',
            'gmt_offset',
            'country_rus',
            'country_eng'
        );
        $count = count($searchFields);
        for($i = 0 ; $i <$count; $i++){
            $field = 'p.'.$searchFields[$i];
            $xpr = $this->query
                ->expr()
                ->like($field, $this->query->expr()
                    ->literal($token)
                );
            if($i == 0){
                $this->mergeScope(array(
                    'where' => [$xpr]
                ));
            } else {
                $this->mergeScope(array(
                    'orWhere' => [$xpr]
                ));

            }
        }
        $this->mergeScope(array('setMaxResults' => 10));


    }

} 