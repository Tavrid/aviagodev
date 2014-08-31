<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 27.03.14
 * Time: 10:57
 */

namespace Acme\CoreBundle\Repository;
use Doctrine\ORM\EntityRepository;

abstract class AbstractRepository extends EntityRepository {
    /**
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $query;

    private $_select = array();

    protected function createQueryWithScopes($param)
    {
        $this->query = $this->createQueryBuilder('p');
        $this->_select = array();
        foreach ($param as $key => $val) {
            if (is_string($key)) {
                call_user_func_array(array($this, $key), (array)$val);
            } else {
                call_user_func(array($this, $val));
            }
        }
    }


    /**
     * @param $param
     * @return \Doctrine\ORM\Query
     */
    public function createQuery($param)
    {
        $this->createQueryWithScopes($param);
        return $this->query->getQuery();
    }





    protected function mergeScope($params)
    {
        foreach ($params as $key => $val) {
            if (is_string($key)) {
                if ($key == 'where') {
                    if ($this->query->getDQLPart('where')) {
                        $key = 'andWhere';
                    }
                } else if ($key == 'orderBy') {
                    if ($this->query->getDQLPart('orderBy')) {
                        $key = 'addOrderBy';
                    }
                } else if ($key == 'params') {
                    foreach ($val as $k => $v) {
                        $this->query->setParameter($k, $v);
                    }
                    continue;
                } else if ($key == 'select') {
                    $val = array_merge($this->_select, $val);
                    $this->_select = $val;
                }
                call_user_func_array(array($this->query, $key), (array)$val);
            } else {
                if ($val == 'where') {
                    if ($this->query->getDQLPart('where')) {
                        $val = 'andWhere';
                    }
                } else if ($key == 'orderBy') {
                    if ($this->query->getDQLPart('orderBy')) {
                        $key = 'addOrderBy';
                    }
                } else if ($key == 'params') {
                    foreach ($val as $k => $v) {
                        $this->query->setParameter($k, $v);
                    }
                    continue;
                } else if ($key == 'select') {
                    $val = array_merge($this->_select, $val);
                    $this->_select = $val;
                }
                call_user_func(array($this->query, $val));
            }
        }
    }



    public function createBaseTree($level = 3,$usePosition = true){
        for ($i = 1; $i <= $level;  $i ++){
            $p = 's_'.$i;
            if ($i == 1){
                $p = 'p';
            }
            $param = array(
                'select' => array($p),
                'orderBy' => array($p.'.id')
            );
            if($usePosition){
                $param['orderBy'] =  array($p.'.position');
            }
            if($i == 1){
                $param['where'] = $this->query->expr()->isNull($p.'.parent');
            } else {
                $c = 's_'.($i-1);
                if ($i == 2){
                    $c = 'p';
                }
                $param['leftJoin'] = array($c.'.children',$p);

            }
            $this->mergeScope($param);

        }
    }

} 