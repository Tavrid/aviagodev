<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 02.09.14
 * Time: 23:23
 */

namespace Bundles\DefaultBundle\Form;

use Acme\AdminBundle\Model\Airports;
use Bundles\DefaultBundle\Form\DataTransformer\SearchFormTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

use Symfony\Component\Translation\TranslatorInterface;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class SearchForm
 * @package Bundles\DefaultBundle\Form
 *
 *
 *
 */
class SearchForm extends AbstractType
{
    /**
     * @var \Acme\AdminBundle\Model\City
     */
    protected $model;
    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @var SearchFormOptions
     */
    protected $searchFormOptions;

    /**
     * @param SessionInterface $session
     * @param SearchFormOptions $searchFormOptions
     */
    public function __construct(SessionInterface $session, SearchFormOptions $searchFormOptions)
    {
        $this->session = $session;
        $this->searchFormOptions = $searchFormOptions;
    }



    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $formOpt = $this->searchFormOptions
            ->getFormOptions();
        $builder
            ->add('departureCity','hidden',['label' =>'frontend.search_form.city_from'])
            ->add('arrivalCity','hidden',['label' =>'frontend.search_form.city_t'])
            ->add('departureCode', 'hidden',['label' =>'frontend.search_form.city_from'])
            ->add('arrivalCode', 'hidden',['label' =>'frontend.search_form.city_to'])
            ->add('departureDate', 'date',['widget' => 'single_text','label' => 'frontend.search_form.date_from'])
            ->add('arrivalDate', 'date',['widget' => 'single_text','label' => 'frontend.search_form.date_to'])
            ->add('direction', 'choice', [
                'label' => 'frontend.search_form.return_way.label',
                'choices' => $formOpt['direction'],
                'data' => 1,
                'multiple' => false,
                'expanded' => true,
                'required' => true,
            ])
            ->add('adults', 'choice', ['choices' => $formOpt['adults'],'label' => 'frontend.search_form.adults'])
            ->add('children', 'choice', ['choices' => $formOpt['children'],'label' => 'frontend.search_form.child'])
            ->add('infant', 'choice', ['choices' => $formOpt['infant'],'label' => 'frontend.search_form.infant'])
            ->add('serviceClass', 'choice', [
                'choices' => $formOpt['serviceClass']])
            ->add('airline', 'choice', [
                'label' => 'frontend.search_form.airline',
                'choices' => $formOpt['airline']
            ])
            ->add('bestPrice', 'checkbox', [
                'label' => 'frontend.search_form.best_price',
                'required' => false,
            ])
            ->add('directFlights', 'checkbox', [
                'label' => 'frontend.search_form.direct_flights',
                'required' => false,
            ]);
        if($options['city_manager']){
            /** @var Airports $model */
            $model = $options['city_manager'];
            $builder->addEventListener(FormEvents::PRE_SET_DATA,function(FormEvent $formEvent)use($model){
                $data = $formEvent->getData();
                if(isset($data['arrivalCode'])){
                    $data['arrivalCity'] = $model->getFormattedNameByIata($data['arrivalCode']);
                }
                if(isset($data['departureCode'])){
                    $data['departureCity'] = $model->getFormattedNameByIata($data['departureCode']);
                }
                $formEvent->setData($data);
            });
        }

        $transformer = new SearchFormTransformer();
        $builder->addModelTransformer($transformer);


    }


    public function getName()
    {
        return 'search_form';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'city_manager' => null
        ));
        $resolver->setRequired(['city_manager']);
    }

} 