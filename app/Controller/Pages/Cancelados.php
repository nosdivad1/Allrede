<?php

namespace App\Controller\Pages;

class Cancelados extends Page
{

    public static function getToken()
    {
        //DEFINE A URL, O TIPO DE REQUISIÇÃO E O BODY DA REQUISIÇÃO
        $url = "https://api.allrede.hubsoft.com.br/oauth/token";
        $type = "POST";
        $body = '
                {
                    "grant_type": "password",
                    "client_id": "116",
                    "client_secret": "emtmzDjPpzMwXuIZ52brsldHlKFg3rrnSrSi6qgh",
                    "username": "paineldevagas@api.com.br",
                    "password": "540EkZ3:RF#dHqE*",
                    "encrypted": false
                }
        ';

        //INICIA O CURL
        $ch = curl_init();

        //CONFIGURA AS OPÇÕES DO CURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = [
            'Content-Type: application/json'
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);

        //EXECUTA O CURL
        $response = curl_exec($ch);

        //TRATA E IMPRIME OS DADOS DO $RESPONSE

        $response = json_decode($response, true);

        $bearer_token = $response['access_token'];

        return $bearer_token;
    }

    public static function getClientes($request)
    {

        $token = self::getToken();


        //DEFINE A URL, O TIPO DE REQUISIÇÃO E O BODY DA REQUISIÇÃO
        $url = "https://api.allrede.hubsoft.com.br/api/v1/integracao/cliente?busca=cpf_cnpj&termo_busca=" . $_GET['cpf'] . "&cancelado=sim&inativo=todos";
        $type = "GET";

        //INICIA O CURL
        $ch = curl_init();

        //CONFIGURA AS OPÇÕES DO CURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);

        //EXECUTA O CURL
        $response = curl_exec($ch);

        //TRATA E IMPRIME OS DADOS DO $RESPONSE

        $response = json_decode($response, true);

        $status = 'false';

        foreach ($response['clientes'][0]['servicos'] as $key => $value) {
            if ($value['status'] != 'Cancelado') {
                $status = 'true';
            }
        }
        echo $status;
    }
}