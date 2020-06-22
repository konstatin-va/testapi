<?php

namespace App\Controller\Api;

use App\Service\Api;
use App\Entity\Product;
use App\Entity\Order;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class OrderController extends Api
{
    public function __construct(Request $request)
    {
        parent::__construct($request);

        // echo $this->apiName;
    }

    public function index()
    {
        return [
            'status' => 'ok',
            'data' => 1,
            'link' => ['href' => "/orders/index"]
        ];
    }

    /**
     * Создаем 20 рандомных товаров - id, name, price
     */
    public function create()
    {
        return [
            'status' => 'ok',
            'data' => 2,
            'link' => ['href' => "/orders/create"],
            'description' => 'список заказов'
        ];
    }

    public function update()
    {
        return [
            'status' => 'ok',
            'data' => 3,
            'link' => ['href' => "/orders/update"],
            'description' => 'создание фейковых товаров'
        ];
    }

    public function delete()
    {
        return [
            'status' => 'ok',
            'data' => 4,
            'link' => ['href' => $this->requestUri],
            'description' => 'попытка оплаты'
        ];
    }
}
