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
            /** @var \Bundles\ApiBundle\Api\Entity\Itineraries[] $itineraries */
            $itineraries = $ticket->getItineraries();
            foreach($itineraries as $k => $iter){
                $successIter = true;
                foreach($filters as $filter){
                    if(!$filter->filterItineraries($iter)){
                        $successIter = false;
                        break;
                    }
                }
                if(!$successIter){
                    unset($itineraries[$k]);
                    continue;
                }
                $successVar = true;
                $variants = $iter->getVariants();
                foreach($variants  as $keyV => $variant){
                    foreach($filters as $filter){
                        if(!$filter->filterVariant($variant)){
                            $successVar = false;
                            break;
                        }
                    }
                    if(!$successVar){
                        unset($variants[$keyV]);
                        continue;
                    }

                    $segments = $variant->getSegments();
                    $successSeg = true;
                    foreach($segments as $keyS => $segment){
                        foreach($filters as $filter){
                            if(!$filter->filterSegment($segment)){

                                $successSeg = false;
                                break;
                            }
                        }
                        if(empty($successSeg)){
                            unset($variants[$keyV]);
                            break;
                        }
                    }



                }
//                var_Dump($variants); exit;
//                if(empty($variants)){
//                    unset($itineraries[$k]);
//                }

                if(!empty($variants)){
                    $data[] = $ticket;
//                    unset($itineraries[$k]);
                }
                break; //Учитывать фильтры только в одну сторону

            }
//            if(!empty($itineraries)){
//                $data[] = $ticket;
//            }

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