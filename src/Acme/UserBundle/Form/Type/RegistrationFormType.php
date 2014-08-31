<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 04.04.14
 * Time: 9:29
 */

namespace Acme\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class RegistrationFormType extends BaseType {

    /**
     * @var ContainerInterface
     */
    protected $container;
    /**
     * @param string $class
     * @param ContainerInterface $container
     */
    public function __construct($class,ContainerInterface $container)
    {
        $this->container = $container;
        parent::__construct($class);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder,$options);
        if($this->container->get('request')->get('provider') === 'facebook'){
            /** @var \Acme\UserBundle\Model\UserSocialInterface $facebook */
            $facebook = $this->container->get('facebook.manager');
            if($facebook->getUser()){
                $this->container->get('session')->set('fbId',$facebook->getUser());
                $email = $facebook->getEmail();
                if($email){
                    $this->container->get('session')->set('facebook_user_email',$email);
                    $builder->get('email')->addEventListener(FormEvents::PRE_SET_DATA,function(FormEvent $event) use ($email){
                        $event->setData($email);
                    });

                }
                $username = $email = $facebook->getUsername();
                if($username){
                    $builder->get('username')->addEventListener(FormEvents::PRE_SET_DATA,function(FormEvent $event) use ($username){
                        $event->setData($username);
                    });

                }
            }
        }

    }

    public function getName()
    {
        return 'Registration';
    }
} 