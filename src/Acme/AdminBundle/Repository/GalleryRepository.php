<?php


namespace Acme\AdminBundle\Repository;
use Acme\CoreBundle\Repository\AbstractRepository;

class GalleryRepository extends AbstractRepository {
    public function sortByPosition(){
        $this->mergeScope(array('orderBy' => 'p.position'));
    }

    public function show(){
        $this->mergeScope(array('where' => 'p.is_show = true'));
    }
} 