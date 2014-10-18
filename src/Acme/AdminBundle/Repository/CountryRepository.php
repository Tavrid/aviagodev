<?php

namespace Acme\AdminBundle\Repository;

use Acme\CoreBundle\Repository\AbstractRepository;

class CountryRepository extends AbstractRepository {

    public function mask() {
        $this->mergeScope([
            'where' => [$this->query->expr()->isNotNull('p.passport_mask')]
        ]);
    }

    public function countryList() {
        $this->query
                ->orderBy('p.passport_mask', 'DESC')
                ->addOrderBy('p.name');
    }

}
