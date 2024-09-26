<?php

namespace App\Controller\Pages;

class GenerateShortLink extends Page
{

    public static function getToken($request)
    {

        //DEFINE A URL, O TIPO DE REQUISIÇÃO E O BODY DA REQUISIÇÃO
        $url = "https://api.allrede.hubsoft.com.br/oauth/token";
        $type = "POST";
        $body = '{
        
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
        $response = json_decode($response, true);
        return $response['access_token'];
    }

    public static function generateIndexcShortLink($request)
    {
        if (!isset($_GET['cpf']) || empty($_GET['cpf']) || strlen($_GET['cpf']) < 11) {
            return '
            {
                "error": "CPF não informado"
            }
            ';
        }
        $token = self::getToken($request);

        $url = "https://api.allrede.hubsoft.com.br/api/v1/integracao/cliente?busca=cpf_cnpj&termo_busca=" . $_GET['cpf'];
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

        $response = json_decode($response, true);

        $dados_do_cliente = $response['clientes'][0];

        $nome_razaosocial = $dados_do_cliente['nome_razaosocial'];
        $documento = $dados_do_cliente['cpf_cnpj'];
        $genero = $dados_do_cliente['genero'];
        $telefone = $dados_do_cliente['telefone_primario'];
        $email = $dados_do_cliente['email_principal'];
        $servico_selecionado = $response['clientes'][0]['servicos'][$_GET['servico'] - 1];
        $plano = $servico_selecionado['nome'];
        $valor_do_plano = $dados_do_cliente['servicos'][$_GET['servico'] - 1]['valor'];
        $data_cadastro = $servico_selecionado['data_cadastro'];
        $uf = $dados_do_cliente['servicos'][$_GET['servico'] - 1]['endereco_fiscal']['estado'];
        $cidade = $dados_do_cliente['servicos'][$_GET['servico'] - 1]['endereco_fiscal']['cidade'];
        $bairro = $response['clientes'][0]['servicos'][$_GET['servico'] - 1]['endereco_fiscal']['bairro'];
        $tipo_pessoa = $dados_do_cliente['tipo_pessoa'];
        $cod_cliente = $dados_do_cliente['id_cliente'];
        $data_nascimento = $dados_do_cliente['data_nascmento'];



        //DEFINE A URL, O TIPO DE REQUISIÇÃO E O BODY DA REQUISIÇÃO
        $url = "https://indecx.com/v3/integrations/authorization/token";
        $type = "GET";

        //INICIA O CURL
        $ch = curl_init();
        //CONFIGURA AS OPÇÕES DO CURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = [
            'Company-Key: $2b$10$kXKY7gV9Jd7VNRH34yoXFetWeHEJX76vXIKcvXryUFm7dONYAP6fu'
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);

        //EXECUTA O CURL
        $response = curl_exec($ch);
        $response = json_decode($response, true);
        $token = $response['authToken'];


        //DEFINE A URL, O TIPO DE REQUISIÇÃO E O BODY DA REQUISIÇÃO
        $url = "https://indecx.com/v3/integrations/actions/J77LPF7Q/invites";
        $type = "POST";
        $body =
            '{
                "customers":[
                {
                "nome":"' . $nome_razaosocial . '",
                "nome_razaosocial":"' . $nome_razaosocial . '",
                "genero":"' . $genero . '",
                "plano":"' . $plano . '",
                "Valor_do_Plano":"' . $valor_do_plano . '",
                "cpf_cnpj":"' . $documento . '",
                "email":"' . $email . '",
                "telefone":"' . $telefone . '",
                "data_habilitação":"' . $data_cadastro . '",
                "UF":"' . $uf . '",
                "Cidade":"' . $cidade . '",
                "Bairro":"' . $bairro . '",
                "Tipo_pessoa":"' . $tipo_pessoa . '",
                "Código_cliente":"' . $cod_cliente . '",
                "Data_nascimento":"' . $data_nascimento . '"
                }
            ]
        }';

        //INICIA O CURL
        $ch = curl_init();

        //CONFIGURA AS OPÇÕES DO CURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);

        //EXECUTA O CURL
        $response = curl_exec($ch);


        $response = json_decode($response, true);


        return $response['customers'][0]['shortUrl'];
    }
}
