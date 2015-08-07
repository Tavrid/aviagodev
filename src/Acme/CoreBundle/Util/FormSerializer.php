<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 21.07.15
 * Time: 20:54
 */

namespace Acme\CoreBundle\Util;


use Symfony\Component\Form\FormInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class FormSerializer
 * @package Acme\CoreBundle\Util
 */
class FormSerializer
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }


    /**
     * @param FormInterface $form
     * @param array $formVars
     * @return array
     */
    public function serializeForm(FormInterface $form,$formVars = ['id','full_name','label','data','value','choices'])
    {
        $data = $this->extractClientData($form,$formVars);
        $viewChildren = $form->createView()->children;
        if(isset($viewChildren['_token'])){
            $_token = $form->createView()->children['_token'];

            $data['_token'] = array_intersect_key(
                $_token->vars,
                array_flip($formVars)
            );
        }
        return $data;
    }

    public function serializeFormError(FormInterface $form)
    {
        $result = array();
        foreach ($form->getErrors() as $error) {
            $result['errors'][] = $error->getMessage();
        }
        foreach ($form->all() as $child) {
            $errors = $this->serializeFormError($child);
            if ($errors) {
                $result[$child->getName()] = $errors;
            }
        }
        return $result;
    }

    /**
     * @param FormInterface $form
     * @param array $formVars
     * @return array
     */
    private function extractClientData(FormInterface $form,$formVars)
    {


        if ($form->count() > 0) {
            $result = array();
            foreach ($form as $name => $child) {
                $result[$name] = $this->extractClientData($child,$formVars);
            }
            return $result;
        }
        $view = $form->createView();
        $errors = [];

        foreach($form->getErrors() as $error){
            $errors[] = $error->getMessage();
        }

        $vars = $view->vars;
        if(isset($vars['full_name']) && $form->getParent() && $form->getParent()->getConfig()->getType()->getName() == 'choice'){
            $vars['full_name'] = $form->getParent()->createView()->vars['full_name'];
        }

        $data = array_intersect_key(
            $vars,
            array_flip($formVars)
        );
        if(isset($data['label'])){
            $data['label'] = $this->translator->trans($data['label']);
        }
        $data['errors'] = $errors;

        return $data;
    }

}