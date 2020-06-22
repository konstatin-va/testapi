<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes->add('api_products', '/api/product')
        ->controller([App\Controller\ProductApiController::class])
        ->methods(['GET', 'POST'])
    ;
    $routes->add('api_orders', '/api/order')
        ->controller([App\Controller\OrderApiController::class])
        ->methods(['GET', 'POST', 'PATCH'])
    ;
};