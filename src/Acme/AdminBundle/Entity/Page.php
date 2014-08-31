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
use Acme\CoreBundle\Validator\Multifield;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Doctrine\Common\Collections\ArrayCollection;

class Page extends  AbstractEntity{

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
    protected $text;

    /**
     * @var string

     *
     */
    protected $page;


    /**
     * @var ArrayCollection
     */
    protected $menu;
    /**
     * @var boolean
     */
    protected $isShow;


    public function __toString(){
        return $this->getName();
    }
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
        $metadata->addPropertyConstraint('text', new Multifield(array(
            'fields' => array(
                'foo' =>array('sub_multi_field','fields' =>array(
                     'bar1' => array('field',new Assert\NotBlank(), new Assert\Length(array('min' => 3))),
                     'bar2' => array('field',new Assert\NotBlank(), new Assert\Length(array('min' => 3))),
                )
            )
        ))));

    }

    /**
     * @var boolean
     */
    private $is_show;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->media = new \Doctrine\Common\Collections\ArrayCollection();
        $this->menu = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Page
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
     * Set text
     *
     * @param string $text
     * @return Page
     */
    public function setText($text)
    {
        $this->text = json_encode($text);

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
//        return array('foo' => uniqid());
        return json_decode($this->text,true);
    }

    /**
     * Set is_show
     *
     * @param boolean $isShow
     * @return Page
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
     * Set page
     *
     * @param string $page
     * @return Page
     */
    public function setPage($page)
    {
        $this->page =$page;

        return $this;
    }

    /**
     * Get page
     *
     * @return string 
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Add menu
     *
     * @param \Acme\AdminBundle\Entity\Menu $menu
     * @return Page
     */
    public function addMenu(\Acme\AdminBundle\Entity\Menu $menu)
    {
        $this->menu[] = $menu;

        return $this;
    }

    /**
     * Remove menu
     *
     * @param \Acme\AdminBundle\Entity\Menu $menu
     */
    public function removeMenu(\Acme\AdminBundle\Entity\Menu $menu)
    {
        $this->menu->removeElement($menu);
    }

    /**
     * Get menu
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMenu()
    {
        return $this->menu;
    }
}
