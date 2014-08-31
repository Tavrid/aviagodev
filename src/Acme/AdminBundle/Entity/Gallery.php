<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 27.03.14
 * Time: 10:40
 */

namespace Acme\AdminBundle\Entity;
use Acme\CoreBundle\Entity\AbstractEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Acme\CoreBundle\Model\Position;
use Doctrine\ORM\Event\LifecycleEventArgs;

class Gallery extends  AbstractEntity{

    /**
     * @var integer
     */
    protected  $id;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string

     *
     */
    protected $description;


    /**
     * @var boolean
     */
    protected  $is_show;

    /**
     * @var int
     */
    protected $position = 1;

    /**
     * @var ArrayCollection
     */
    protected $media;





    public function preUpdate(PreUpdateEventArgs $args) {
        $changes = $args -> getEntityChangeSet();
        if (isset($changes['position'])) {
            $positionObj = new Position($args -> getEntityManager(), $this);
            $position = (isset($changes['position'][0])) ? $changes['position'][0] : $this -> getPosition();
            $toPosition = $args -> getEntity() -> getPosition();
            $positionObj -> insertPosition($position, $toPosition);
        }

    }

    public function postPersist(LifecycleEventArgs $args) {
        $positionObj = new Position($args -> getEntityManager(), $this);
        $positionObj -> insertPosition(-156, 1);
    }

    public function postRemove(LifecycleEventArgs $args) {
        $positionObj = new Position($args -> getEntityManager(), $this);
        $positionObj -> removePosition($this->getPosition());
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->media = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Gallery
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Description
     *
     * @param string $desc
     * @return Gallery
     */
    public function setDescription($desc)
    {
        $this->description = $desc;

        return $this;
    }

    /**
     * Get Description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set is_show
     *
     * @param boolean $isShow
     * @return Gallery
     */
    public function setIsShow($isShow)
    {
        $this->is_show = $isShow;

        return $this;
    }

    /**
     * Get is_show
     *
     * @return boolean 
     */
    public function getIsShow()
    {
        return $this->is_show;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Gallery
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Add media
     *
     * @param Media $media
     * @return Gallery
     */
    public function addMedia(Media $media)
    {
        $this->media[] = $media;

        return $this;
    }

    /**
     * Remove media
     *
     * @param Media $media
     */
    public function removeMedia(Media $media)
    {
        $this->media->removeElement($media);
    }

    /**
     * Get media
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMedia()
    {
        return $this->media;
    }
}
