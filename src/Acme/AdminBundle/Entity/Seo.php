<?php

namespace Acme\AdminBundle\Entity;


class Seo
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $prefix;

    /**
     * @var string
     */
    private $template;


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
     * Set prefix
     *
     * @param string $prefix
     * @return Seo
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get prefix
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set template
     *
     * @param string $template
     * @return Seo
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }
}
