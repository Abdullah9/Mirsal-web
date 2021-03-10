<?php

namespace App\Helpers;

class HyperPayCopyAndPay
{
    public static function request($price, $brand, $arr)
    {
        $entityId = "8ac9a4c877fc8e5a0178165e445840ef";
        $mada = "8ac9a4c877fc8e5a0178165fc817410b";

        if ($brand == 'MADA') {
            $entityId = $mada;
        }

        $url = "https://oppwa.com/v1/checkouts";
        $data = "entityId=" . $entityId .
            "&currency=SAR".
            "&amount=" . $price .
            "&paymentType=DB".
            "&merchantTransactionId=".$arr['merchantTransactionId'].
            "&customer.email=".$arr['customerEmail'].
            "&billing.country=SA".
            "&billing.street1=Shaikh Hasan Ibn Hussain Ibn Ali Rd".
            "&billing.city=Riyadh".
            "&billing.state=Riyadh".
            "&billing.postcode=13246".
            "&customer.givenName=".$arr['customerName'].
            "&customer.surname=".$arr['customerName']
            
            ;

        // var_dump($data); exit;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjOWE0Yzg3N2ZjOGU1YTAxNzgxNjVkY2ViYjQwZTB8SmJaeDdwcTNTYw=='));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        return json_decode($responseData, true);
    }

    public static function paymentStatus($resourcePath, $brand)
    {
        $entityId = "8ac9a4c877fc8e5a0178165e445840ef";
        $mada = "8ac9a4c877fc8e5a0178165fc817410b";

        if ($brand == 'MADA') {
            $entityId = $mada;
        }
        $url = "https://oppwa.com/" . $resourcePath;
        $url .= "?entityId=" . $entityId;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjOWE0Yzg3N2ZjOGU1YTAxNzgxNjVkY2ViYjQwZTB8SmJaeDdwcTNTYw=='));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return json_decode($responseData, true);
    }

}