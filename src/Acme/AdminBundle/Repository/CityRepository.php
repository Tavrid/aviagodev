<?php


namespace Acme\AdminBundle\Repository;
use Acme\CoreBundle\Repository\AbstractRepository;

class CityRepository extends AbstractRepository {

    public function searchByToken($token){

        $tokens = $this->createTokens($token);

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
        $xpressions = array();
        for($i = 0 ; $i <$count; $i++){
            $field = 'p.'.$searchFields[$i];
            $xprPar = array();
            foreach($tokens as $t){
                $xprPar[] = $this->query
                    ->expr()
                    ->like($field, $this->query->expr()
                        ->literal($t)
                    );
            }
            $xpressions[] = call_user_func_array([$this->query
                ->expr(),'orX'],$xprPar);
//
        }
        $xpr = call_user_func_array([$this->query
            ->expr(),'orX'],$xpressions);
        $this->mergeScope(array(
            'setMaxResults' => 10,
            'where' => [$xpr]
        ));
//        var_dump($this->query->getDQL());exit;

    }

    /**
     * @param $token
     * @return array
     */
    protected function createTokens($token){
        $tokens = array(
            $token,
            $this->correctString($token)
        );
        foreach($tokens as &$t){
            $t = '%'.$t.'%';
        }

        return array_unique($tokens);
    }

    private function correctString ($string)
    {
        $search = array(
            "й","ц","у","к","е","н","г","ш","щ","з","х","ъ",
            "ф","ы","в","а","п","р","о","л","д","ж","э",
            "я","ч","с","м","и","т","ь","б","ю"
        );
        $replace = array(
            "q","w","e","r","t","y","u","i","o","p","[","]",
            "a","s","d","f","g","h","j","k","l",";","'",
            "z","x","c","v","b","n","m",",","."
        );
        return str_replace($replace,$search, $string);
    }


} 