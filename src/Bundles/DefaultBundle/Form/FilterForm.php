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
    /**
     * @var \Bundles\ApiBundle\Api\Entity\Ticket[]
     */
    protected $searchResponse;
    protected $departureAirportCh;
    protected $arrivalAirportCh;
    protected $airlineCh;

    public function __construct(SearchResponse $searchResponse= null){
        $this->searchResponse = $searchResponse;
        $this->airlineCh = array(0 => 'Все');
        $this->departureAirportCh = array(0 => 'Все');
        $this->arrivalAirportCh = array(0 => 'Все');
        foreach($this->searchResponse as $ticket){
            foreach($ticket->getItineraries() as $itineraries){
                foreach($itineraries->getVariants()  as $variant){
                    $i = 0;
                    $count = count($variant->getSegments());
                    foreach($variant->getSegments() as $segment){
                        if($i==0){
                            $this->departureAirportCh[$segment->getDepartureAirport()] = $segment->getDepartureAirportName();
                        }
                        $this->airlineCh[$segment->getMarketingAirline()] = $segment->getMarketingAirlineName();
                        $i++;
                        if($count == $i){
                            $this->arrivalAirportCh[$segment->getArrivalAirport()] = $segment->getArrivalAirportName();
                        }
                    }

                }
            }
        }
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('departure_airport','choice',['label' => 'Аэропорт вылета','choices' => $this->departureAirportCh])
            ->add('arrival_airport','choice',['label' => 'Аэропорт прилета','choices' => $this->arrivalAirportCh])
            ->add('departure_time','choice',['label' => 'время вылета'])
            ->add('arrival_time','choice',['label' => 'время прилета'])
            ->add('airline','choice',['label' => 'Авиакомпания','choices' => $this->airlineCh]);

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