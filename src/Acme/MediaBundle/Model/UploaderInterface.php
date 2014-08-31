<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 30.03.14
 * Time: 13:38
 */

namespace Acme\MediaBundle\Model;


use Symfony\Component\HttpFoundation\File\Exception\FileException;


interface UploaderInterface {


    /**
     * @return mixed
     */
    public function getType();

    /**
     * @param $size
     * @param null $entity
     * @return string
     */
    public function getFile($size, $entity = null);

    /**
     *
     * @param integer $id
     * @return \Acme\MediaBundle\Model\Uploader
     */
    public function getFiles($id);

    /**
     *
     * @return string
     */
    public function getUrl();

    /**
     *
     * @param string $patch
     * @return Uploader
     */
    public function setUrl($patch);


    /**
     * @param bool $id
     * @return bool
     * @throws \Symfony\Component\HttpFoundation\File\Exception\FileException
     */
    public function delete($id = FALSE);

    /**
     *
     * @param string $code
     * @return string
     * @throws FileException
     */
    public function readFile($code);

    /**
     *
     * @param integer $id
     *
     */
    public function saveFiles($id);

    /**
     * @param $files
     * @param null $id
     * @return bool
     */
    public function upload($files,$id = null);


    /**
     * @param $id
     * @return bool
     */
    public function removeFilesByEntityId($id);


    public function removeFiles();
} 