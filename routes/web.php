<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->post('login','AuthController@login');



$router->group(["prefix"=>"users","middleware"=>"auth"],function() use($router){
    $router->get('/me','AuthController@me');
});

$router->group(["prefix"=>"merchants","middleware"=>["auth","merchant"]],function() use($router){
    $router->get('/{id_merchants}/omzet','MerchantController@omzet');
    $router->get('/{id_merchants}/outlets/{id_outlets}/omzet','MerchantController@omzet');
});


