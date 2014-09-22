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
        foreach($this->response as $ticket){
            $success = true;
            /** @var \Bundles\ApiBundle\Api\Entity\Itineraries[] $itineraries */
            $itineraries = $ticket->getItineraries();
            foreach($itineraries as $k => $iter){
                $successIter = true;
                foreach($filters as $filter){
                    if(!$filter->filterItineraries($iter)){
                        unset($itineraries[$k]);
                        $successIter = false;
                        break;
                    }
                }
                if(!$successIter){
                    continue;
                }
                $successVar = true;
                $variants = $iter->getVariants();
                foreach($variants  as $k => $variant){
                    foreach($filters as $filter){
                        if(!$filter->filterVariant($variant)){
                            $successVar = false;
                            unset($variants[$k]);
                            break;
                        }
                    }
                    if(!$successVar){
                        continue;
                    }

                    $segments = $variant->getSegments();
                    foreach($segments as $k => $segment){
                        $successSeg = true;
                        foreach($filters as $filter){
                            if(!$filter->filterSegment($segment)){
                                $successSeg = false;
                                unset($segments[$k]);
                                break;
                            }
                        }


                    }
                    if(empty($segments)){
                        unset($variants[$k]);
                    }


                }
                if(empty($variants)){
                    unset($itineraries[$k]);
                }

            }


            if(!empty($itineraries)){
                $data[] = $ticket;
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