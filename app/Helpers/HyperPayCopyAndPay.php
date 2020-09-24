<?php

namespace App\Helpers;

class HyperPayCopyAndPay
{
    public static function request($price) {

        // $amount = $invoice->price;
        $amount = $price;
        $url = "https://test.oppwa.com/v1/checkouts";
        $data = "entityId=8ac7a4ca74490e2601744972410e0145" .
                    "&amount=".$amount."" .
                    "&currency=SAR" .
                    "&paymentType=DB";
                    
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                       'Authorization:Bearer OGFjN2E0Y2E3NDQ5MGUyNjAxNzQ0OTcxZGU0ODAxNDF8WEJha3lTd05NMw=='));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        
        return json_decode($responseData, true);
    }

    public static function paymentStatus($resourcePath){
        $url = "https://test.oppwa.com/".$resourcePath;
        $url .= "?entityId=8ac7a4ca74490e2601744972410e0145";
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                       'Authorization:Bearer OGFjN2E0Y2E3NDQ5MGUyNjAxNzQ0OTcxZGU0ODAxNDF8WEJha3lTd05NMw=='));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return json_decode($responseData, true);
    }

}
