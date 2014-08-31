<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 07.04.14
 * Time: 15:39
 */

namespace Acme\UserBundle\Model;


class Facebook implements UserSocialInterface {

    protected $facebook;
    protected $facebookData;

    function __construct(\Facebook $facebook){
        $this->facebook = $facebook;
    }

    /**
     * @param $redirectUrl
     * @return mixed
     */
    public function getLoginUrl($redirectUrl)
    {
        return $this->facebook->getLoginUrl(array('scope' => 'email','redirect_uri' => $redirectUrl));
    }

    /**
     * @return mixed
     */
    public function getLogoutUrl()
    {
        return $this->facebook->getLogoutUrl();
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->facebook->getUser();
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        if(!$this->facebookData){
            $this->facebookData = $this->facebook->api('/me');
        }
        if(isset($this->facebookData['username'])){
            return $this->facebookData['username'];
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        if(!$this->facebookData){
            $this->facebookData = $this->facebook->api('/me');
        }
        if(isset($this->facebookData['email'])){
            return $this->facebookData['email'];
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getSocialId()
    {
       return $this->facebook->getUser();
    }

    /**
     * @return mixed
     */
    public function getData(){
        if(!$this->facebookData){
            $this->facebookData = $this->facebook->api('/me');
        }
        return $this->facebookData;
    }
}