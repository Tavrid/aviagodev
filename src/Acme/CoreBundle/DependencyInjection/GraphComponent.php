<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 22.01.14
 * Time: 23:16
 */

namespace Acme\CoreBundle\DependencyInjection;
use Symfony\Component\Validator\Constraints as Assert;
use Acme\CoreBundle\Model\AbstractModel;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

abstract class GraphComponent {

    protected $name;
    protected $parent = null;
    protected $children = array();
    protected $fieldMap;
    protected $dataModel;
    protected $uploader;
    protected $desc = null;

    // Constructor
    public function __construct($name, $fieldMap)
    {
        $this->name = $name;
        $this->fieldMap = $this->createFieldMap($fieldMap);
    }

    /**
     * @param $desc
     * @return $this
     */
    public function setDescription($desc){
        $this->desc = $desc;
        return $this;
    }

    /**
     * @return mixed
     */

    public function getDescription(){
        return $this->desc;
    }

    /**
     * @param AbstractModel $model
     * @return $this
     */
    public function setDataModel(AbstractModel $model){
        $this->dataModel = $model;
        return $this;
    }

    public function setUploaderService($uploader){
        $this->uploader = $uploader;
    }

    public function getUploaderService(){
        return $this->uploader;
    }

    /**
     * @return AbstractModel|null
     */
    public function getDataModel(){
        return $this->dataModel;
    }

    /**
     * @param GraphComponent $c
     * @return $this
     */
    public function setParent(GraphComponent $c){
        $this->parent = $c;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParent(){
        return $this->parent;
    }

    /**
     * @param null $name
     * @return $this[]
     */
    public function getChildren($name = null){
        if($name){
            return $this->children[$name];
        }
        return $this->children;
    }

    public function getChildrenNamesArray(){
        return array_keys($this->children);
    }

    /**
     * @param GraphComponent $c
     * @return $this
     */
    public function add(GraphComponent $c){
        $c->setParent($this);
        $this->children[$c->getName()] = $c;
        return $this;
    }

    /**
     * @param GraphComponent $c
     * @return $this
     */
    public function remove(GraphComponent $c){
        unset($this->children[$c->getName()]);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @param $fieldMap
     * @return mixed
     */
    protected function createFieldMap(array $fieldMap){
        foreach ($fieldMap as $key => &$val){
            if(array_key_exists('field',$val) || array_key_exists('multi_field',$val)){
                $newVal = array('field');
                if(isset($val['validator'])){
                    foreach ($val['validator'] as $class => $params){
                        $reflection = new \ReflectionClass($class);
                        if(is_array($params)){
                            $newVal[] = $reflection->newInstanceArgs($params);
                        } else {
                            $newVal[] = $reflection->newInstance();

                        }
                    }
                }
                unset($val['validator']);
                unset($val['field']);
                $val = array_merge($val,$newVal);
            } else if(array_key_exists('sub_multi_field',$val)){
                $val = array_merge($val,array('sub_multi_field','fields'=> $this->createFieldMap($val['fields'])));
                unset($val['sub_multi_field']);
            } else {
                $val = $this->createFieldMap($val);
            }
        }
        return $fieldMap;
    }

    /**
     * @param FormBuilderInterface $builder
     * @return FormBuilderInterface
     */
    public function buildBaseFields(FormBuilderInterface $builder ){
        $tag = $this->getName();
        $builder->add('parent','entity',array(
            'label' => 'Родитель',
            'required' => false,
            'constraints' => array(new Assert\NotBlank()),
            'class' => 'AcmeCoreBundle:Graph',
            'query_builder' => function(EntityRepository $er) use ($tag) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC')
                        ->where('u.tag = :tag')
                        ->setParameter('tag',$tag);
                },
        ))->add('name',null,array('label' => 'Заголовок'))
            ->add('uri',null,array('label' => 'Ссылка','required' => false));
        return $builder;
    }

    public function getFieldMap(){
        return $this->fieldMap;
    }

} 