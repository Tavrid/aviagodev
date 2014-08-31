<?php

namespace Acme\AdminBundle\Entity;

use Acme\CoreBundle\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;
use Acme\MediaBundle\Model\UploaderEntityInterface;


//use Doctrine\Common\Collections\ArrayCollection;

/**
 * Media

 */
class Media extends AbstractEntity implements UploaderEntityInterface {

    /**
     * @var integer
     *
     */
    private $id;

    /**
     * @var string

     * 
     */
    private $type;

    /**
     * @var string
     *
     */
    private $name;
    /**
     * @var string
     *
     */
    private $originName;

    /**
     * @var string
     *
     */
    private $mimeType;

    /**
     * @var string
     *
     */
    private $size;

    /**
     * @var string
     *
     */
    private $dimensions;

    /**
     * @var string
     *
     */
    private $extension;

    /**
     * @var string
     *
     */
    private $path;

    /**
     * @var boolean
     */
    private $avatar = false;


    /**
     */
    private $page;

    /**
     */
    private $slider;
    /**
     *
     */
    private $gallery;
    /**
     * @var
     */

    private $project;

    /**
     * @return string
     */

    /**
     * @var \Acme\AdminBundle\Entity\Task
     */
    private $task;


    public function __toString() {
        return $this->getName();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
       return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Media
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set origin name
     *
     * @param string $name
     * @return Media
     */
    public function setOriginName($name){
        $this->originName = $name;
        return $this;
    }

    /**
     * Get origin name
     *
     * @return string
     */
    public function getOriginName(){
        return $this->originName;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     * @return Media
     */
    public function setAvatar($avatar) {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar() {
        return $this->avatar;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Media
     */
    public function setPath($path) {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * Set mimeType
     *
     * @param string $mimeType
     * @return Media
     */
    public function setMimeType($mimeType) {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string 
     */
    public function getMimeType() {
        return $this->mimeType;
    }

    /**
     * Set size
     *
     * @param string $size
     * @return Media
     */
    public function setSize($size) {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string 
     */
    public function getSize() {
        return number_format($this->size / 1024);
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Media
     */
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set dimensions
     *
     * @param string $dimensions
     * @return Media
     */
    public function setDimensions($dimensions) {
        $this->dimensions = $dimensions;

        return $this;
    }

    /**
     * Get dimensions
     *
     * @return string 
     */
    public function getDimensions() {
        return $this->dimensions;
    }

    /**
     * Set extension
     *
     * @param string $extension
     * @return Media
     */
    public function setExtension($extension) {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string 
     */
    public function getExtension() {
        return $this->extension;
    }



    /**
     * Set project
     *
     * @param Page $page
     * @return Media
     */
    public function setPage(\Acme\AdminBundle\Entity\Page $page = null)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get project
     *
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set slider
     *
     * @param Slider $slider
     * @return Media
     */
    public function setSlider(Slider $slider = null)
    {
        $this->slider = $slider;

        return $this;
    }

    /**
     * Get slider
     *
     * @return Slider
     */
    public function getSlider()
    {
        return $this->slider;
    }

    /**
     * Set gallery
     *
     * @param Gallery $gallery
     * @return Media
     */
    public function setGallery(Gallery $gallery = null)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery
     *
     * @return Gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }

}
