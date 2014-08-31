<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10.05.14
 * Time: 19:15
 */

namespace Acme\CoreBundle\Model;


interface PositionInterface {
    /**
     * @return array;
     */
    public function getAdditionalFields();

    public function getPosition();

    public function setPosition($position);

    public function getId();

} 