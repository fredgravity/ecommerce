<?php

namespace App\classes;

class Hubtel{





    public function checkout($invoice){

        $basicAuthKey = 'Basic '. getenv('AUTH_KEY');
        $requestUrl = 'https://api.hubtel.com/v1/merchantaccount/onlinecheckout/invoice/create';
        $createInvoice = json_encode($invoice,JSON_UNESCAPED_SLASHES);


        $ch = curl_init($requestUrl);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $createInvoice);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_HTTPHEADER, array(
            'Authorization: '.$basicAuthKey,
            'Cache-Control: no-cache',
            'Content-Type: application/json'

        ));

        $result = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);


    }



    public function checkoutErrors(){
        if($this->_error){
            echo $this->_error;
        }else{
            //redirect customer to checkout
            $responseParam = json_decode($this->_result);
            // print_r($responseParam);
            $redirectUrl = $responseParam->response_text;
            Redirect::to($redirectUrl);
        }
    }




    public function payment($invoice){

        $clientId = getenv('CLIENT_ID');
        $clientSecret = getenv('CLIENT_SECRET');
        $basicAuthKey = 'Basic '. base64_encode($clientId . ':' . $clientSecret);
        $requestUrl = getenv('HUBTEL_REQUEST_URL');
        $creatInvoice = json_encode($invoice);

//pnd($creatInvoice);

        $ch = curl_init($requestUrl);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $creatInvoice);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_HTTPHEADER, array(
            'Authorization: '.$basicAuthKey,
            'Cache-Control: no-cache',
            'Content-Type: application/json'

        ));

        $result = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error){
            return $error;
        }else{
            $response = json_encode($result);
            return $result;
        }


    }




}
?>