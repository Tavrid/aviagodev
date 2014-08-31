<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29.03.14
 * Time: 14:34
 */

namespace Acme\AdminBundle\Event;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Acme\CoreBundle\Model\AbstractModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Form;
use Acme\MediaBundle\Model\UploaderInterface;

class ControllerEvent extends Event {
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;
    /**
     * @var AbstractModel|null
     */
    protected $response;
    /**
     * @var
     */
    protected $dataManager;
    /**
     * @var AbstractType
     */
    protected $formType;
    /**
     * @var Form
     */
    protected $form;
    /**
     * @var UploaderInterface|null
     */
    protected $uploaderManager;

    /**
     * @param Request $request
     */
    public function __construct(Request $request){
        $this->request = $request;
    }

    public function setResponse(Response $response){
        $this->response = $response;
        return $this;
    }

    public function getResponse(){
        return $this->response;
    }

    /**
     * @return AbstractModel|null
     *
     */
    public function getDataManager(){
        return $this->dataManager;
    }

    /**
     * @param AbstractModel $manager
     * @return $this
     */
    public function setDataManager(AbstractModel $manager){
        $this->dataManager = $manager;
        return $this;
    }

    /**
     * @param AbstractType $form
     * @return $this
     */
    public function setFormType(AbstractType $form){
        $this->formType = $form;
        return $this;
    }



    /**
     * @return AbstractType
     */
    public function getFormType(){
        return $this->formType;
    }

    /**
     * @param Form $form
     * @return $this
     */

    public function setFrom(Form $form){
        $this->form = $form;
        return $this;
    }

    /**
     * @return Form
     */
    public function getForm(){
        return $this->form;
    }

    /**
     * @param UploaderInterface $manager
     * @return $this
     */
    public function setUploaderManager(UploaderInterface $manager = null){
        $this->uploaderManager = $manager;
        return $this;
    }

    /**
     * @return null|UploaderInterface
     */
    public function getUploaderManager(){
        return $this->uploaderManager;
    }
} 