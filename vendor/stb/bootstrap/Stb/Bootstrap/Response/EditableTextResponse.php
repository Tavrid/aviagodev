<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 26.08.14
 * Time: 23:44
 */

namespace Stb\Bootstrap\Response;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormInterface;

class EditableTextResponse  extends Response{

    public function __construct($form,$string, $status = 200, $headers = array())
    {
        $headers = array_replace(array('Content-Type'=>'application/json'),$headers);

        parent::__construct(json_encode(array(
            'string' => $string,
            'form' => $form
        )), $status, $headers);
    }

} 