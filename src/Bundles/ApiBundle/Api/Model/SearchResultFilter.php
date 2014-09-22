<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 20.09.14
 * Time: 22:10
 */

namespace Bundles\ApiBundle\Api\Model;
use Bundles\ApiBundle\Api\Response\SearchResponse;

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
     * @param $filters \Closure[]
     * @return array
     */
    public function getData($page,$filters){

        $data = [];
        $ret = [];
        foreach($this->response as $response){
            $success = true;
            foreach($filters as $filter){
                if(!$filter($response)){
                    $success = false;
                    break;
                }
            }
            if($success){
                $data[] = $response;
            }

        }


        $start =  (($page-1)*$this->countOnPage);
        $end = $page*$this->countOnPage;

        for ($i = $start; $i< $end; $i++){
            if(isset($data[$i])){
                $ret[] = $data[$i];
            }
        }

        return $ret;
    }

} 