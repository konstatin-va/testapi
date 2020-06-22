<?php

namespace App\Service\OrderPayments;

class YandexPayment implements iOrderPayment
{
    protected $targetSite = 'https://ya.ru/';

    public function doPayment($orderId) {

        $ch = curl_init($this->targetSite);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY,true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);

        if (200 == curl_getinfo($ch, CURLINFO_RESPONSE_CODE)) {
            return true;
        }

        return false;
    }
}
