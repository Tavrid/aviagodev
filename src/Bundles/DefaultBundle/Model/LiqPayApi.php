<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 05.03.15
 * Time: 21:55
 */

namespace Bundles\DefaultBundle\Model;


use Acme\AdminBundle\Entity\Order;
use Bundles\ApiBundle\Api\Model\ResponseTranslatorInterface;
use Bundles\ApiBundle\Api\Response\BookInfoResponse;
use Bundles\ApiBundle\Api\Util\TicketEntityCreator;
use Symfony\Component\Routing\RouterInterface;

class LiqPayApi
{

    const SUCCESS_PAY = 'success';
    const FAIL_PAY = 'failure';
    const WAIT_SECURE = 'wait_secure';
    const PROCESSING = 'processing';
    const SANDBOX = 'sandbox';
    const WAIT_ACCEPT = 'wait_accept';

    protected $publicKey;
    protected $privateKey;

    protected $router;

    protected $responseTranslator;

    public function __construct($publicKey, $privateKey, RouterInterface $router,ResponseTranslatorInterface $responseTranslator)
    {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
        $this->router = $router;
        $this->responseTranslator = $responseTranslator;
    }

    public function getStatuses()
    {
        return [
            self::SUCCESS_PAY => 'Успешный платеж',
            self::FAIL_PAY => 'Неуспешный платеж',
            self::WAIT_SECURE => 'Платеж на проверке',
            self::PROCESSING => 'Платеж обрабатывается',
            self::WAIT_ACCEPT => 'Деньги с клиента списаны, но магазин еще не прошел проверку',
            self::SANDBOX => 'Тестовый платеж'
        ];
    }

    public function createForm(Order $order)
    {
        //{"originCity":"DP","destinationCity":"NY","departureDate":"100514"}
        $bookInfoResponse = new BookInfoResponse(new TicketEntityCreator($this->responseTranslator));
        $bookInfoResponse->setResponseData($order->getOrderInfo());
        $ticket = $bookInfoResponse->getEntity()->getTicket();
        $segment = $ticket->getFirstItinerarie()->getFirstVariant()->getDepartureSegment();
        $liqpay = new \LiqPay($this->publicKey, $this->privateKey);
        $html = $liqpay->cnb_form(array(
            'version' => '3',
            'amount' => $order->getPrice(),
            'currency' => 'RUB',
            'description' => 'Order',
            'order_id' => $order->getId(),
            'sandbox' => 1,
            'dae' => json_encode([
                'airLine' => $segment->getMarketingAirlineName(),
                'ticketNumber' => $order->getPnr(),
                'passengerName' => $ticket->getSurname(),
                'flightNumber' => $segment->getFlightNumber(),
                'originCity' => $segment->getDepartureCity(),
                'destinationCity' => $segment->getDepartureCityName(),
                'departureDate' => $segment->getDepartureDate()
            ]),
            'server_url' => 'http://webservices.aero/',
            'result_url' => $this->router->generate('bundles_default_api_return_liqpay', array("orderID" => $order->getOrderId()), true)
        ));
        return $html;
    }

    /**
     * @param Order $order
     * @return bool
     */
    public function checkStatus(Order $order)
    {
        $liqpay = new \LiqPay($this->publicKey, $this->privateKey);
        $res = $liqpay->api("payment/status", array(
            'version' => '3',
            'order_id' => $order->getId()
        ));
        if ($res) {
            if ($res->result == 'error') {
                return false;
            }
            if ($res->order_id == $order->getId() && $res->amount == $order->getPrice()) {
                return $res->status;
            }
        }
        return false;

    }


}