<?php


namespace Acme\AdminBundle\Repository;
use Acme\CoreBundle\Repository\AbstractRepository;

class OrderRepository extends AbstractRepository {

    public function lastItems($level = 3,$usePosition = true){

        $this->mergeScope(array(
            'orderBy' => ['p.id','desc']
        ));
    }

} 