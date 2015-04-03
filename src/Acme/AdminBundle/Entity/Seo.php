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
    /**
     * @var \Acme\AdminBundle\Entity\AviaAirports
     */
    private $cityFrom;


    /**
     * Set cityFrom
     *
     * @param \Acme\AdminBundle\Entity\AviaAirports $cityFrom
     * @return Seo
     */
    public function setCityFrom(\Acme\AdminBundle\Entity\AviaAirports $cityFrom = null)
    {
        $this->cityFrom = $cityFrom;

        return $this;
    }

    /**
     * Get cityFrom
     *
     * @return \Acme\AdminBundle\Entity\AviaAirports 
     */
    public function getCityFrom()
    {
        return $this->cityFrom;
    }
    /**
     * @var \Acme\AdminBundle\Entity\AviaAirports
     */
    private $cityTo;


    /**
     * Set cityTo
     *
     * @param \Acme\AdminBundle\Entity\AviaAirports $cityTo
     * @return Seo
     */
    public function setCityTo(\Acme\AdminBundle\Entity\AviaAirports $cityTo = null)
    {
        $this->cityTo = $cityTo;

        return $this;
    }

    /**
     * Get cityTo
     *
     * @return \Acme\AdminBundle\Entity\AviaAirports 
     */
    public function getCityTo()
    {
        return $this->cityTo;
    }
    /**
     * @var string
     */
    private $h1;


    /**
     * Set h1
     *
     * @param string $h1
     * @return Seo
     */
    public function setH1($h1)
    {
        $this->h1 = $h1;

        return $this;
    }

    /**
     * Get h1
     *
     * @return string 
     */
    public function getH1()
    {
        return $this->h1;
    }
}
