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
     * @return \Acme\AdminBundle\Entity\Seo|null
     */
    public function parseUri($uri)
    {
        preg_match('#(.+?)[A-Я]{1}#u',$uri,$mathes);
        if(isset($mathes[1])){
            $prefix = $mathes[1];
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
            $seoData = null;

            if(!$cityFrom && !$cityFrom){
                return null;
            }

            /** @var \Acme\AdminBundle\Entity\Seo $seoData */
            $seoData = $this->getRepository()->findOneBy(array(
                'prefix' => $prefix,
                'cityFrom' => $cityFrom,
                'cityTo' => $cityTo
            ));
            if(!$seoData){
                $seoData = $this->getRepository()->findOneBy(array(
                    'prefix' => $prefix,
                    'cityFrom' => null,
                    'cityTo' => null
                ));
                $seoData->setCityFrom($cityFrom)
                    ->setCityTo($cityTo);
            }
            return $seoData;
        }
        return null;
    }

}