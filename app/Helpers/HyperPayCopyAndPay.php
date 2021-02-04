<?php

namespace App\Helpers;

class HyperPayCopyAndPay
{
    public static function request($price, $brand, $arr)
    {
        $entityId = "8ac7a4ca74490e2601744972410e0145";
        $mada = "8ac7a4ca74490e2601744972a9c30149";

        if ($brand == 'MADA') {
            $entityId = $mada;
        }

        $url = "https://test.oppwa.com/v1/checkouts";
        $data = "entityId=" . $entityId .
            "&currency=SAR".
            "&amount=" . $price .
            
            "&paymentType=DB".
            "&merchantTransactionId=".$arr['merchantTransactionId']
            // "&customer.email=bap.greenery@gmail.com".
            // "&billing.street1=test street".
            // "&billing.city=Davao".
            // "&billing.state=Davao Del Sur".
            // "&billing.country=SA".
            // "&billing.postcode=11564".
            // "&customer.givenName= test name".
            // "&customer.surname= test surname"
            ;

        // var_dump($data); exit;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjN2E0Y2E3NDQ5MGUyNjAxNzQ0OTcxZGU0ODAxNDF8WEJha3lTd05NMw=='));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
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
        $entityId = "8ac7a4ca74490e2601744972410e0145";
        $mada = "8ac7a4ca74490e2601744972a9c30149";

        if ($brand == 'MADA') {
            $entityId = $mada;
        }
        $url = "https://test.oppwa.com/" . $resourcePath;
        $url .= "?entityId=" . $entityId;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjN2E0Y2E3NDQ5MGUyNjAxNzQ0OTcxZGU0ODAxNDF8WEJha3lTd05NMw=='));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return json_decode($responseData, true);
    }

}