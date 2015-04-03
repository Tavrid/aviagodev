<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 03.04.15
 * Time: 21:54
 */

namespace Acme\AdminBundle\Model;
use Acme\CoreBundle\Model\AbstractModel;

class Seo extends AbstractModel
{
    /**
     * @param $uri
     * @return \Acme\AdminBundle\Entity\Seo|null|object
     */
    public function parseUri($uri)
    {
        $seoData = $this->getSeoDataByUri($uri);
        if(!$seoData){
            return null;
        }
        $prefix = $seoData->getPrefix();
        $cit = trim(str_replace($prefix,'',$uri),'/,-');
        $citArray = explode('–',$cit);
        $cityFrom = $this->container->get('admin.city.manager')
            ->getByName($citArray[0]);
        if(!$cityFrom){
            return null;
        }
        $cityTo = null;
        if(isset($citArray[1])){
            $cityTo = $this->container->get('admin.city.manager')
                ->getByName($citArray[1]);
        }
        $res = $this->getRepository()->findOneBy(array(
            'prefix' => $prefix,
            'cityFrom' => $cityFrom->getId(),
            'cityTo' => $cityTo ? $cityTo->getId() : null
        ));
        if(!$res){
            $seoData->setCityFrom($cityFrom);
            if($cityTo){
                $seoData->setCityTo($cityTo);
            }
            $res = $seoData;
        }

        return $res;

    }

    /**
     * @param $uri
     * @return \Acme\AdminBundle\Entity\Seo
     */
    public function getSeoDataByUri($uri)
    {
        /** @var \Acme\AdminBundle\Entity\Seo[] $seoData */
        $seoData = $this->getRepository()->findAll();
        foreach ($seoData as $seo){

            if(strpos($uri,$seo->getPrefix(),0) !== false){
                return $seo;
            }
        }
        return null;
    }

}