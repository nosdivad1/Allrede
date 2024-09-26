<?php

namespace App\Controller\Pages;

class Faturas extends Page
{

    public static function getFaturas()
    {
        //DEFINE A URL, O TIPO DE REQUISIÇÃO E O BODY DA REQUISIÇÃO
        //$url = "https://api.7az.com.br/v2/integrations/omnichannel/invoices/17983705/pix-status";
        //$url = "https://api.7az.com.br/v2/integrations/omnichannel/invoices?txId=02396652109";
        $url = "https://api.7az.com.br/v2/integrations/omnichannel/invoices/17983705/payment-data";
        //$url = "https://api.7az.com.br/v2/integrations/omnichannel/invoices/17983705/pdf";
        $type = "GET";

        //INICIA O CURL
        $ch = curl_init();
        //CONFIGURA AS OPÇÕES DO CURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = [
            'x-api-key: 66f35d24-f068-4023-be01-5f746bb1b587'
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);

        //EXECUTA O CURL
        $response = curl_exec($ch);
        $response = json_decode($response, true);
        echo "<pre>";
        print_r($response);
        echo "</pre>";
    }
}
