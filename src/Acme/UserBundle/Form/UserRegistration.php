<?php

namespace Acme\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
//use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;

class UserRegistration extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('username', null, array('label' => 'Логин'))
                ->add('password', 'password', array('label' => 'Пароль'))
                ->add('passwordConfirm', 'password', array('label' => 'Повторите пароль'));
        $builder->addEventListener(FormEvents::POST_BIND, function(FormEvent $event) {
                    $data = $event->getForm()->getData();
                    if ($data->getPassword() !== $data->getPasswordConfirm()) {

                        $event->getForm()->addError(new FormError('Пароли не совпадают'));
                    }
                });
    }

    public function getName() {
        return 'acme_adminbundle_user_registration';
    }

}
