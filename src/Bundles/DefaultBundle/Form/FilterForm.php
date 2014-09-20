<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 20.09.14
 * Time: 21:56
 */

namespace Bundles\DefaultBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;


use Symfony\Component\Validator\Constraints as Assert;
use Bundles\ApiBundle\Api\Response\SearchResponse;

class FilterForm extends AbstractType {

    protected $searchResponse;

    public function __construct(SearchResponse $searchResponse= null){
        $this->searchResponse = $searchResponse;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('airport','choice',['label' => 'Аэропорт'])
            ->add('departure_time','choice',['label' => 'время вылета'])
            ->add('arrival_time','choice',['label' => 'время прилета'])
            ->add('airline','choice',['label' => 'Авиакомпания']);

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        // TODO: Implement getName() method.
        return 'filter';
    }

} 