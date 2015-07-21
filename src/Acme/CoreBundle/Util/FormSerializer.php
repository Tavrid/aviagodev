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
     * @return array
     */
    public function serializeForm(FormInterface $form)
    {
        return $this->extractClientData($form);
    }

    /**
     * @param FormInterface $form
     * @return array
     */
    private function extractClientData(FormInterface $form)
    {

        if ($form->count() > 0) {
            $result = array();
            foreach ($form as $name => $child) {
                $result[$name] = $this->extractClientData($child);
            }
            return $result;
        }
        $view = $form->createView();
        $errors = [];

        foreach($form->getErrors() as $error){
            $errors[] = $error->getMessage();
        }
        $data = array_intersect_key(
            $view->vars,
            [
                'id' => '',
                'name' => '',
                'full_name' => '',
                'label' => '',
                'valid' => '',
                'data' => '',
                'value' => '',
                'attr' => '',
                'choices' => []

            ]);
        $data['label'] = $this->translator->trans($data['label']);
        $data['errors'] = $errors;

        return $data;
    }

}