<?php

use \App\Http\Response;
use \App\Controller\Pages;

//ROTA HOME
$obRouter->get('/', [
    function () {
        return new Response(200, Pages\Home::getHome());
    }
]);

//ROTA SOBRE
$obRouter->get('/sobre', [
    function () {
        return new Response(200, Pages\About::getAbout());
    }
]);

//ROTA DE DEPOIMENTOS
$obRouter->get('/depoimentos', [
    function ($request) {
        return new Response(200, Pages\Testimony::getTestimonies($request));
    }
]);

//ROTA DE DEPOIMENTOS (insert)
$obRouter->post('/depoimentos', [
    function ($request) {

        return new Response(200, Pages\Testimony::insertTestimony($request));
    }
]);

//ROTA DE CLIENTES CANCELADOS (insert)
$obRouter->get('/cancelados', [
    function ($request) {

        return new Response(200, Pages\Cancelados::getClientes($request));
    }
]);

$obRouter->get('/generatelink', [
    function ($request) {
        return new Response(200, Pages\GenerateShortLink::generateIndexcShortLink($request));
    }
]);