<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 01.04.14
 * Time: 20:25
 */

namespace Acme\MediaBundle\EventListener;
use Doctrine\Common\EventArgs;
use Acme\MediaBundle\Model\UploaderInterface;
class MediaListener {
    protected $uploader;
    public function __construct(UploaderInterface $uploader){
        $this->uploader = $uploader;
    }
    function postRemove(EventArgs $event){
        $this->uploader->removeFiles();
    }

} 