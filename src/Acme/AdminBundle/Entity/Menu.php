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
use Acme\CoreBundle\Model\PositionInterface;
class Menu extends  AbstractEntity implements PositionInterface{

    /**
     * @var integer
     */
    protected  $id;
    /**
     * @var string
     */
    protected $name;

    /**
     * @var boolean
     */
    protected  $is_show;
    /**
     * @var int
     */
    protected $position = 1;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $children;

    /**
     * @var \Acme\AdminBundle\Entity\Menu
     */
    private $parent;


    /**
     * @var Page
     */
    protected $page;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());

    }

    public function getAdditionalFields(){
        return array('parent');
    }


    public function __toString(){
        return $this->getName();
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
     * @return Menu
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
     * Set page
     *
     * @param \Acme\AdminBundle\Entity\Page $page
     * @return Menu
     */
    public function setPage(\Acme\AdminBundle\Entity\Page $page = null)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return \Acme\AdminBundle\Entity\Page 
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set is_show
     *
     * @param boolean $isShow
     * @return Menu
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
     * @return Menu
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
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add children
     *
     * @param \Acme\AdminBundle\Entity\Menu $children
     * @return Menu
     */
    public function addChild(\Acme\AdminBundle\Entity\Menu $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Acme\AdminBundle\Entity\Menu $children
     */
    public function removeChild(\Acme\AdminBundle\Entity\Menu $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \Acme\AdminBundle\Entity\Menu $parent
     * @return Menu
     */
    public function setParent(\Acme\AdminBundle\Entity\Menu $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Acme\AdminBundle\Entity\Menu 
     */
    public function getParent()
    {
        return $this->parent;
    }
}
