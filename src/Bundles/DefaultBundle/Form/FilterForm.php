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
use Bundles\ApiBundle\Api\Filter\Time;
use Symfony\Component\Translation\TranslatorInterface;
use Bundles\ApiBundle\Api\Response\SearchResponse;

class FilterForm extends AbstractType {

    /**
     * @var \Bundles\ApiBundle\Api\Entity\Ticket[]
     */
    protected $searchResponse;

    /**
     *
     * @var type 
     */
    protected $departureAirportCh;

    /**
     *
     * @var array 
     */
    protected $arrivalAirportCh;

    /**
     *
     * @var array 
     */
    protected $airlineCh;
    /**
     *
     * @var TranslatorInterface 
     */
    protected $translator;
    public function __construct(TranslatorInterface $translation) {
        $this->translator = $translation;
    }

    protected function createValues(SearchResponse $searchResponse = null) {
        $this->searchResponse = $searchResponse;
        $this->airlineCh = array(0 => $this->translator->trans('frontend.filter_form.all'));
        $this->departureAirportCh = array(0 => $this->translator->trans('frontend.filter_form.all'));
        $this->arrivalAirportCh = array(0 => $this->translator->trans('frontend.filter_form.all'));
        foreach ($this->searchResponse as $ticket) {
            foreach ($ticket->getItineraries() as $itineraries) {
                foreach ($itineraries->getVariants() as $variant) {
                    $i = 0;
                    $count = count($variant->getSegments());
                    foreach ($variant->getSegments() as $segment) {
                        if ($i == 0) {
                            $this->departureAirportCh[$segment->getDepartureAirport()] = $segment->getDepartureAirportName();
                        }
                        $this->airlineCh[$segment->getMarketingAirline()] = $segment->getMarketingAirlineName();
                        $i++;
                        if ($count == $i) {
                            $this->arrivalAirportCh[$segment->getArrivalAirport()] = $segment->getArrivalAirportName();
                        }
                    }
                }
                break; //Учитывать фильтры только в одну сторону
            }
        }
    }

    //утро день вечер и ночь
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->createValues($options['searchResponse']);
        $filterValues = Time::getFilterValues();
        foreach ($filterValues as &$val){
            $val = $this->translator->trans($val);
        }
        $builder
                ->add('departure_airport', 'choice', ['label' => 'frontend.filter_form.departure_airport', 'choices' => $this->departureAirportCh])
                ->add('arrival_airport', 'choice', ['label' => 'frontend.filter_form.arrival_airport', 'choices' => $this->arrivalAirportCh])
                ->add('departure_time', 'choice', [
                    'multiple' => true,
                    'label' => 'frontend.filter_form.departure_time',
                    'choices' => $filterValues,
                    "expanded" => true,
                ])
                ->add('arrival_time', 'choice', [
                    'multiple' => true,
                    'label' => 'frontend.filter_form.arrival_time',
                    'choices' => $filterValues,
                    "expanded" => true,
                ])
                ->add('airline', 'choice', ['label' => 'frontend.filter_form.airline', 'choices' => $this->airlineCh,'multiple' => true]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setRequired(array('searchResponse'));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return 'filter';
    }

}
