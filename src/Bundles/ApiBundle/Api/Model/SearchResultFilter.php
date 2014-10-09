<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 20.09.14
 * Time: 22:10
 */

namespace Bundles\ApiBundle\Api\Model;
use Bundles\ApiBundle\Api\Response\SearchResponse;

use Bundles\ApiBundle\Api\Filter\Filter;

class SearchResultFilter {
    /**
     * @var integer
     */
    protected $countOnPage;
    /**
     * @var SearchResponse
     */
    protected $response;

    /**
     * @param SearchResponse $response
     * @param $countOnPage
     */

    protected $countPages = 0;

    public function __construct(SearchResponse $response,$countOnPage){
        $this->response = $response;
        $this->countOnPage = $countOnPage;
        $this->countPages = ceil(count($this->response)/$countOnPage);
    }

    /**
     * @return mixed
     */
    public function getCountPages()
    {
        return $this->countPages;
    }

    /**
     * @param mixed $countPages
     */
    public function setCountPages($countPages)
    {
        $this->countPages = $countPages;
    }

    /**
     * @param $page
     * @param $filters Filter[]
     * @return array
     */
    public function getData($page,$filters){

        $data = [];
        $ret = [];
        if(!empty($filters)){

            foreach($this->response as $ticket){
                $r = true;
                foreach($filters as $filter){
                    $r = $filter->filterItem($ticket);
                    if(!$r){
                        break;
                    }
                }
                if($r){
                    $data[] = $ticket;
                }
            }
        } else {
            $data = $this->response;

        }


        $start =  (($page-1)*$this->countOnPage);
        $end = $page*$this->countOnPage;

        for ($i = $start; $i< $end; $i++){
            if(isset($data[$i])){
                $ret[] = $data[$i];
            }
        }
        $this->countPages = ceil(count($data)/$this->countOnPage);
        return $ret;
    }

} 