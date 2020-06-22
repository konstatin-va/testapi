<?php

namespace App\Service\OrderPayments;

interface iOrderPayment
{
    public function doPayment(int $orderId);
}
