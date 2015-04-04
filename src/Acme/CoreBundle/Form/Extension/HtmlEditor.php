<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 03.04.15
 * Time: 22:46
 */

namespace Acme\CoreBundle\Form\Extension;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HtmlEditor extends AbstractType
{
    public function getName()
    {
        return 'html_editor';
    }

    public function getParent()
    {
        return 'textarea';
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_replace($view->vars,[
            'width' => $options['width']
        ]);

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
           'width' => 300
        ]);
    }


}