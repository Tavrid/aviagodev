<?php

/**
 * UploaderEntityInterface.php (UTF-8)
 *
 * Jun 21, 2013 12:18:08 AM
 * @author abdulhakim
 */

namespace Acme\MediaBundle\Model;
use Acme\MediaBundle\Entity\Media;
interface UploaderEntityInterface {

    /**
     * Set name
     *
     * @param string $name
     * @return Media
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string 
     */
    public function getName();

    /**
     * Set origin name
     *
     * @param string $name
     * @return Media
     */
    public function setOriginName($name);

    /**
     * Get origin name
     *
     * @return string
     */
    public function getOriginName();

    /**
     * Set path
     *
     * @param string $path
     * @return Media
     */
    public function setPath($path);

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath();

    /**
     * Set mimeType
     *
     * @param string $mimeType
     * @return Media
     */
    public function setMimeType($mimeType);

    /**
     * Get mimeType
     *
     * @return string 
     */
    public function getMimeType();

    /**
     * Set size
     *
     * @param string $size
     * @return Media
     */
    public function setSize($size);

    /**
     * Get size
     *
     * @return string 
     */
    public function getSize();

    /**
     * Set type
     *
     * @param string $type
     * @return Media
     */
    public function setType($type);

    /**
     * Get type
     *
     * @return string 
     */
    public function getType();

    /**
     * Set dimensions
     *
     * @param string $dimensions
     * @return Media
     */
    public function setDimensions($dimensions);

    /**
     * Get dimensions
     *
     * @return string 
     */
    public function getDimensions();

    /**
     * Set extension
     *
     * @param string $extension
     * @return Media
     */
    public function setExtension($extension);

    /**
     * Get extension
     *
     * @return string 
     */
    public function getExtension();

    /**
     * Set avatar
     *
     * @param string $avatar
     * @return Media
     */
    public function setAvatar($avatar);

    /**
     * @return mixed
     */
    public function getAvatar();
}
