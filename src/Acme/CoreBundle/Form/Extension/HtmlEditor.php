<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 03.04.15
 * Time: 22:46
 */

namespace Acme\CoreBundle\Form\Extension;
use Symfony\Component\Form\AbstractType;

class HtmlEditor extends AbstractType
{
    public function getName()
    {
        return 'html_editor';
    }

}