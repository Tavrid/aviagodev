<?php

/**
 * Uploader.php (UTF-8)
 *
 * 03.06.2013 16:11:53
 * @author ablyakim
 */

namespace Acme\MediaBundle\Model;

use Acme\CoreBundle\Model\AbstractModel;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Imagine\Imagick\Imagine as Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Image\ImageInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Acme\MediaBundle\EventListener\MediaListener;

class Uploader extends AbstractModel implements UploaderInterface, \Iterator, \ArrayAccess {

    /**
     *
     * @var string
     * 
     * Полный путь к папке
     */
    protected $_path;

    /**
     * относительный web путь
     * @var string
     */
    protected $_url;

    /**
     *
     * @var string
     * 
     * загруженные файлы
     */
    protected $_uploadedFiles = array();

    /**
     *
     * @var array
     * 
     * массив размеров изображений
     */
    protected $_dimensions = array();

    /**
     *
     * @var array
     */
    protected $_entities;
    /*
     * Массив файлов
     * 
     */
    protected $_files;

    /**
     *
     * @var array
     * минимальный размер
     */
    protected $minDimension;

    /**
     * Максимальное колличество загружаемых файлов
     * 
     */
    public $maxCount;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $_targetRepository;


    /**
     * @param ContainerInterface $container
     * @param AbstractModel $targetModel
     * @param array $params
     */
    function __construct(ContainerInterface $container,AbstractModel $targetModel, $params) {
        $container->get('uploader.configuration.service')->resolveParams($params['params']);

        $this->type = (isset($params['params']['type'])) ? $params['params']['type'] : NULL;
        $this->_path = (isset($params['params']['path'])) ? $params['params']['path'] : '';
        $this->_url = (isset($params['params']['route'])) ? $params['params']['route'] : '';
        $this->maxCount = (isset($params['params']['count'])) ? $params['params']['count'] : 10;
        $this->minDimension = (isset($params['params']['min_dimension'])) ? $params['params']['min_dimension'] : '20_20';
        $this->_targetRepository = $targetModel;
        if (!isset($params['params']['dimensions']['crop'])) {
            $params['params']['dimensions']['crop'] = array('100_100');
        }
        $this->_dimensions = $params['params']['dimensions'];
        parent::__construct($container, $params['params']['entity']);
    }


    public function getType(){
        return $this->type;
    }


    /**
     * Коллекция сущностей для итератора
     * @param array $entities
     */
    public function setEntities($entities) {
        $this->_entities = $entities;
    }

    /**
     * 
     * @return array
     */
    public function getEntities() {
        return $this->_entities;
    }

    /**
     * 
     * @return string
     */
    public function getUrl() {
        return $this->_url;
    }

    /**
     * 
     * @param string $patch
     * @return \Acme\MediaBundle\Model\Uploader
     */
    public function setUrl($patch) {
        $this->_url = $patch;
        return $this;
    }


    /**
     * Полный путь к файлу на сервере
     * @param string $path
     * @return \Acme\MediaBundle\Model\Uploader
     */
    public function setPath($path) {
        $this->_path = $path;
        return $this;
    }

    /**
     * 
     * @return string
     */
    public function getPath() {
        return $this->_path;
    }

    /**
     * 
     * @param integer $id
     * 
     */
    public function saveFiles($id) {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $q = $qb->update($this->entityClass, 'u')
                ->set('u.'.$this->getMappedColumn(), $id)
                ->where('u.type = :type')
                ->andWhere($qb->expr()->isNull('u.'.$this->getMappedColumn()))
                ->setParameter('type', $this->type)
                ->getQuery();
        return $q->execute();
    }

    /**
     * @param $id
     * @return mixed
     */

    public function setAvatar($id){
        $entity = $this->getRepository()->find($id);
        $f = PropertyAccess::createPropertyAccessor()->getValue($entity,$this->getMappedColumn());
        if($f){
            $entities = $this->getRepository()->findBy(array(
                $this->getMappedColumn() => $f->getId(),
                'avatar' => true,
                'type'=>$this->getType()
            ));
        } else {
            $entities = $this->getRepository()->findBy(array(
                $this->getMappedColumn() => null,
                'avatar' => true,
                'type'=>$this->getType()
            ));
        }
        /** @var UploaderEntityInterface[] $entities */
        foreach ($entities as $e){
            $e->setAvatar(false);
            $this->save($e);
        }
        $entity->setAvatar(true);
        return $this->save($entity);
    }

    /**
     * @param $files
     * @param null $id
     * @return bool
     */
    public function upload($files,$id = null) {

        foreach ($files as $file) {
            if (!$this->move($file)) {
                return FALSE;
            }
        }
        if (!empty($this->_uploadedFiles)) {
            if($id){
                $entity = $this->_targetRepository->find($id);
                $obj = $this->getEntity();
                PropertyAccess::createPropertyAccessor()
                    ->setValue($obj,$this->getMappedColumn(),$entity);
                $this->setEntity($obj);
            }
            $this->getEntity()->setName($this->_uploadedFiles['name'])
                ->setOriginName($this->_uploadedFiles['origin_name'])
                ->setMimeType($this->_uploadedFiles['mime_type'])
                ->setPath($this->_uploadedFiles['path'])
                ->setSize($this->_uploadedFiles['size'])
                ->setType($this->type)
                ->setDimensions($this->_uploadedFiles['dimensions'])
                ->setExtension($this->_uploadedFiles['extension']);
            $this->save();
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public function removeFilesByEntityId($id) {
        /** @var UploaderInterface[] $entities */
        $entities = $this->getFiles($id);
        foreach ($entities as $val) {
            $val->delete();
        }
        return true;

    }

    /**
     * @param bool $id
     * @return bool
     * @throws \Symfony\Component\HttpFoundation\File\Exception\FileException
     */
    public function delete($id = FALSE) {
        if ($id) {
            $entity = $this->getRepository()->find($id);
        } else {
            $entity = $this->getEntity();
        }
        if (!$entity) {
            throw new FileException('Not file in entity.');
        }

        $this->setEntity($entity);

        $listener = new MediaListener($this);
        $this->getDoctrine()
            ->getManager()
            ->getEventManager()
            ->addEventListener('postRemove',$listener);
        return $this->remove();
    }


    public function removeFiles() {
        $entity = $this->getEntity();
        $sizeArray = explode(',', $entity->getDimensions());
        $basePatch = $this->_path . '/' . $entity->getPath() . '/';
        @unlink( $basePatch. $entity->getName() . '.' . $entity->getExtension());
        foreach ($sizeArray as $sizeSting) {
            @unlink($basePatch . $entity->getName() . '.' . $sizeSting . '.' . $entity->getExtension());
        }
        $this->removeEmptyDirRecursive($entity->getPath());
    }

    protected function removeEmptyDirRecursive($patch){
        $basePatch = $this->_path.'/';
        $dirs = explode('/',$patch);
        $root = $basePatch.$dirs[0];
        try {
            $it = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($root, \FilesystemIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST
            );
            /** @var \SplFileInfo[] $it */
            foreach ($it as $file) {
                if ($file->isDir()) {
                    if(!count(glob($file->getRealPath().'/*'))){
                        rmdir($file->getRealPath());
                    }
                }
            }
            if(!count(glob($root.'/*'))){
                rmdir($root);
            }
        } catch (\Exception $e){

        }
    }





    public function isPlaced($id = NULL){
        $entities = $this->getRepository()
            ->findBy(array($this->getMappedColumn() => $id, 'type' => $this->type));
        return $this->maxCount > count($entities);
    }


    /**
     *
     * @param integer $id
     * @return \Acme\MediaBundle\Model\Uploader
     */
    public function getFiles($id) {
        if($id){
            $entity = $this->_targetRepository->find($id);

            $entities = $entity->getMedia();
            if ($entities) {
                $this->_entities = array();
                foreach ($entities as $e){
                    $this->_entities[] = $e;
                }
            }
        } else {

            $entities = $this->getRepository()
                ->findBy(array('type' => $this->getType(), $this->getMappedColumn() => null),array('id' => 'ASC'));
            if($entities){
                $this->_entities = $entities;
            }
        }
        return $this;
    }


    /**
     * @param $size
     * @param null $entity
     * @return string
     */
    public function getFile($size, $entity = null) {
        if ($entity && is_object($entity)){
            $this->setEntity($entity);
        }
        if(is_array($entity)){
            $dimensions = explode(',', $entity['dimensions']);
        } else {
            $dimensions = explode(',', $this->getEntity()->getDimensions());
        }
        if(in_array($size,$dimensions)){
            $path = is_array($entity) ? $entity['path'] : $this->getEntity()->getPath();
            $entityName = is_array($entity) ? $entity['name'] : $this->getEntity()->getName();
            $entityExtension = is_array($entity) ? $entity['extension'] : $this->getEntity()->getExtension();
            return '/web/files/'.$path.'/'.$entityName.'.'.$size.'.'.$entityExtension;
        }
        $entityId = is_array($entity) ? $entity['id'] : $this->getEntity()->getId();
        $entityName = is_array($entity) ? $entity['name'] : $this->getEntity()->getName();
        $entityExtension = is_array($entity) ? $entity['extension'] : $this->getEntity()->getExtension();
        $code = base64_encode($entityId . '.' . $size);
        return $this->container->get('router')->generate($this->getUrl(),
            array(
                'code' => $code,
                'extension' => $entityExtension,
                'name' => $entityName,
                'type' => $this->type)
        );
    }

    /**
     * 
     * @param string $code
     * @return string
     * @throws FileException
     */
    public function readFile($code) {
        list($id, $size) = explode('.', base64_decode($code));
        if (!$this->getEntity()) {
            throw new FileException('Unable to entity.');
        }
        $this->setEntity($this->getRepository()->find($id));
        if (!$this->getEntity()) {
            throw new FileException('Not file in entity.');
        }
        return $this->resize($size);
    }



    /**
     * @return string
     */
    protected function getMappedColumn(){
        $columnName = '';
        $em = $this->getDoctrine()->getManager();
        $cmf = $em->getMetadataFactory();
        $class = $cmf->getMetadataFor(get_class($this->_targetRepository->getEntity()));
        foreach ($class->associationMappings as $field){
            if($field['fieldName'] == 'media'){
                $columnName = $field['mappedBy'];
                break;
            }

        }
        return $columnName;
    }



    /**
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @return boolean
     * @throws FileException
     */
    protected function move(UploadedFile $file) {
        if (!$file->isValid()) {
            return FALSE;
        }

        if(!$this->isPlaced()){
            throw new FileException('Превышен лимит файлов!');
        }
        $minSize = explode('_', $this->minDimension);
        $imagesize = getimagesize($file->getPathname());
        if ($imagesize[0] < $minSize[0] || $imagesize[1] < $minSize[1]) {
            throw new FileException('Image should be less than ' . $this->minDimension);
        }
        $new_name = md5(microtime());
        $target = $this->getTargetPath($new_name);
        $this->_uploadedFiles = array(
            'mime_type' => $file->getMimeType(),
            'extension' => $file->guessExtension(),
            'name' => $new_name,
            'path' => $target,
            'origin_name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'dimensions' => '0'
        );
        if ($file->move($this->_path . '/' . $target . '/', $new_name . '.' . $file->guessExtension())) {
            return TRUE;
        } else {
            throw new FileException(sprintf('Error move file', $this->_path . '/' . $target . '/'));
        }

    }

    /**
     *
     * @param string $fileName
     * @return string относительныйп путь к папке
     * @throws FileException
     */
    protected function getTargetPath($fileName) {
        $dir = substr($fileName, 0, 2) . '/' . substr($fileName, 2, 2);
        if (!is_dir($this->_path . '/' . $dir)) {
            if (false === @mkdir($this->_path . '/' . $dir, 0777, true)) {
                throw new FileException(sprintf('Unable to create the "%s" directory', $this->_path . '/' . $dir));
            }
        }

        return $dir;
    }

    /**
     * 
     * @param string $size
     * @return string|null
     *
     */
    protected function resize($size) {
        $demensions = explode(',', $this->getEntity()->getDimensions());
        $target = $this->_path . '/' . $this->getEntity()->getPath();
        $file = $target . '/' . $this->getEntity()->getName() . '.' . $this->getEntity()->getExtension();
        if (in_array($size, $demensions)) {
            return $target . '/' . $this->getEntity()->getName() . '.' . $size . '.' . $this->getEntity()->getExtension();
        }
        $demensions[] = $size;
        if (in_array($size, $this->_dimensions['resize'])) {
            $imagine = new Imagine();
            $sizeArray = explode('_', $size);

            $sizeImage = getimagesize($file);
            if ($sizeImage[0] >= $sizeImage[1]) {
                $koe = $sizeImage[0] / $sizeArray[0];
                $sizeArray[1] = ceil($sizeImage[1] / $koe);
            } else {
                $koe = $sizeImage[1] / $sizeArray[1];
                $sizeArray[0] = ceil($sizeImage[0] / $koe);
            }

            $sizeBox = new Box($sizeArray[0], $sizeArray[1]);
            $newFile = $target . '/' . $this->getEntity()->getName() . '.' . $size . '.' . $this->getEntity()->getExtension();
            $imagine->open($file)
                    ->resize($sizeBox)
                    ->save($newFile);
            $this->getEntity()->setDimensions(implode(',', $demensions));
            $this->save();
            return $newFile;
        } else if (in_array($size, $this->_dimensions['crop'])) {
            $imagine = new Imagine();
            $sizeArray = explode('_', $size);
            $sizeBox = new Box($sizeArray[0], $sizeArray[1]);
            $newFile = $target . '/' . $this->getEntity()->getName() . '.' . $size . '.' . $this->getEntity()->getExtension();
            $imagine->open($file)
                    ->thumbnail($sizeBox,ImageInterface::THUMBNAIL_OUTBOUND)
                    ->save($newFile);
            $this->getEntity()->setDimensions(implode(',', $demensions));
            $this->save();
            return $newFile;
        }
        return NULL;
    }

    public function __toString() {
        return $this->getEntity()->getName();
    }

    public function rewind() {
        if (is_array($this->_entities)) {
            reset($this->_entities);
        }
    }

    public function current() {
        if (is_array($this->_entities)) {
            $this->setEntity(current($this->_entities));
        }
        return $this;
    }

    public function key() {
        if (is_array($this->_entities)) {
            return key($this->_entities);
        }
        return NULL;
    }

    public function next() {
        if (is_array($this->_entities)) {
            next($this->_entities);
        }
    }

    public function valid() {
        if (is_array($this->_entities)) {
            return key($this->_entities) !== null;
        }
        return FALSE;
    }

    public function offsetExists($offset) {
        return isset($this->_entities[$offset]);
    }

    public function offsetGet($offset) {
        $this->setEntity($this->_entities[$offset]);
        return $this;
    }

    public function offsetSet($offset, $value) {
        return $this->_entities[$offset] = $value;
    }

    public function offsetUnset($offset) {
        unset($this->_entities[$offset]);
    }

}
