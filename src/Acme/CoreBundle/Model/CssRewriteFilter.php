<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 14.07.14
 * Time: 15:32
 */

namespace Acme\CoreBundle\Model;
use Assetic\Asset\AssetInterface;
use Assetic\Filter\FilterInterface;

class CssRewriteFilter implements  FilterInterface {

    public function filterLoad(AssetInterface $asset)
    {
    }


    public function filterDump(AssetInterface $asset)
    {
        $content = $asset->getContent();

        //Do something to $content
        $asset->setContent($content);
    }

} 