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
     * @var AviaAirports
     */
    private $cityTo;

    /**
     * @var AviaAirports
     */
    private $cityFrom;

    /**
     * @var string
     */
    private $h1;
    /**
     * @var array
     */
    private $meta_tags;


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
     * Set cityFrom
     *
     * @param AviaAirports $cityFrom
     * @return Seo
     */
    public function setCityFrom(AviaAirports $cityFrom = null)
    {
        $this->cityFrom = $cityFrom;

        return $this;
    }

    /**
     * Get cityFrom
     *
     * @return AviaAirports
     */
    public function getCityFrom()
    {
        return $this->cityFrom;
    }



    /**
     * Set cityTo
     *
     * @param AviaAirports
     * @return Seo
     */
    public function setCityTo(AviaAirports $cityTo = null)
    {
        $this->cityTo = $cityTo;

        return $this;
    }

    /**
     * Get cityTo
     *
     * @return AviaAirports
     */
    public function getCityTo()
    {
        return $this->cityTo;
    }



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



    /**
     * Set meta_tags
     *
     * @param array $metaTags
     * @return Seo
     */
    public function setMetaTags($metaTags)
    {
        $this->meta_tags = $metaTags;

        return $this;
    }

    /**
     * Get meta_tags
     *
     * @return array 
     */
    public function getMetaTags()
    {
        return $this->meta_tags;
    }
}
