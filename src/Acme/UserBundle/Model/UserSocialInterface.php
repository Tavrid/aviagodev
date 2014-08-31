<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 07.04.14
 * Time: 15:29
 */

namespace Acme\UserBundle\Model;


interface UserSocialInterface {

    /**
     * @param $redirectUrl
     * @return mixed
     */

    public function getLoginUrl($redirectUrl);

    /**
     * @return mixed
     */
    public function getLogoutUrl();

    /**
     * @return mixed
     */
    public function getUser();

    /**
     * @return mixed
     */
    public function getUsername();

    /**
     * @return mixed
     */
    public function getEmail();

    /**
     * @return mixed
     */
    public function getSocialId();

    /**
     * @return mixed
     */
    public function getData();

} 