<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class Home extends Page
{

    /**
     * Método responsável por retornar o conteúdo (view) da nossa home.
     * @return string
     */

    public static function getHome()
    {
        //ORGANIZAÇÃO
        $obOrganization = new Organization;

        //VIEW DA HOME
        $content = View::render('pages/home', [
            'name'          => $obOrganization->name

        ]);

        //RETORNA O JSON DE BOAS VINDAS

        header("Content-Type: application/json", true);
        return json_encode([
            "status" => "success",
            "mensagem" => "isso é uma api"
        ], JSON_UNESCAPED_UNICODE);
    }
}
