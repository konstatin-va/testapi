<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Api\AbstractApi;
use App\Service\OrderPayments\YandexPayment;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;

class OrderApiController extends AbstractApi
{
    protected $apiName = 'order';
    private $entityManager;

    public function __construct(Request $request, EntityManager $entityManager)
    {
        parent::__construct($request);
        $this->entityManager = $entityManager;
    }

    public function index()
    {
        $data = $this->entityManager->getRepository(Order::class)->findOrders($this->entityManager);

        return [
            'status' => 'success',
            'code' => 200,
            'response' => [
                'orders' => $data,
                'Location' => '/' . $this->apiName
            ]
        ];
    }

    /**
     * Создание заказа
     */
    public function create()
    {
        $errorDescription = 'products must be a string in json_encode';

        if (!empty($this->requestParams['products'])) {

            $products = json_decode($this->requestParams['products']);

            if ( is_array($products) && count($products) ) {

                if ($price = $this->entityManager->getRepository(Product::class)->findProductsCost($this->entityManager, $products)) {

                    $order = new Order();

                    $order->setProducts(json_encode($products));
                    $order->setPrice($price);

                    $this->entityManager->persist($order);
                    $this->entityManager->flush();

                    return [
                        'status' => 'success',
                        'code' => 201,
                        'response' => [
                            'order' => [
                                'id' => $order->getId()
                            ],
                            'Location' => '/' . $this->apiName . '/' . $order->getId()
                        ]
                    ];
                }
                else {
                    $errorDescription = 'the order amount must be greater than 0';
                }
            }
        }

        return [
            'status' => 'error',
            'errorInfo' => [
                'code' => 400,
                'description' => $errorDescription,
            ]
        ];
    }

    /**
     * Попытка оплаты и изменение статуса заказа
     */
    public function pay()
    {
        $errorDescription = 'orderId and orderPrice is required';

        if (!empty($this->requestParams['orderId']) and !empty($this->requestParams['orderPrice'])) {

            $orderId = intval($this->requestParams['orderId']);
            $orderPrice = floatval($this->requestParams['orderPrice']);

            if ($order = $this->entityManager->getRepository(Order::class)->find($orderId)) {
                if ($orderPrice == $order->getPrice()) {
                    if (!$order->getStatus()) {

                        $payment = new YandexPayment();
                        if ($payment->doPayment($orderId)) {

                            $order->setStatus(1);
                            $this->entityManager->persist($order);
                            $this->entityManager->flush();

                            return [
                                'status' => 'success',
                                'code' => 200,
                                'response' => [
                                    'order' => [
                                        'id' => $order->getId(),
                                        'status' => $order->getStatus()
                                    ],
                                    'Location' => '/' . $this->apiName . '/' . $order->getId()
                                ]
                            ];
                        } else {
                            $errorDescription = 'the payment service is not available';
                        }
                    } else {
                        $errorDescription = 'the order has already been paid for';
                    }
                } else {
                    $errorDescription = 'wrong the cost of the order';
                }
            } else {
                $errorDescription = 'order not found';
            }
        }

        return [
            'status' => 'error',
            'errorInfo' => [
                'code' => 400,
                'description' => $errorDescription,
            ]
        ];
    }
}
