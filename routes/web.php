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
	$greetings = [
       "Description" => "Majoo omzet transactions report",
       "Developer" => [
          "Name" => "M.Hakim Amransyah",
          "email" => "m.hakim.amransyah.hakim@gmail.com",
          "linkedin" => 'www.linkedin.com/in/hakim-amr',
          "website" => 'http://mhakimamransyah.site/'
       ],
       "App stacks" => [
          $router->app->version(),
          "Mysql"
       ],
       "Postman Collections" => "https://www.getpostman.com/collections/7112c660c747610bbfda"
	];
    return $greetings;
});


$router->post('login','AuthController@login');



$router->group(["prefix"=>"users","middleware"=>"auth"],function() use($router){
    $router->get('/me','AuthController@me');
});

$router->group(["prefix"=>"merchants","middleware"=>["auth","merchant"]],function() use($router){
    $router->get('/{id_merchants}/omzet','MerchantController@omzet');
    $router->get('/{id_merchants}/outlets/{id_outlets}/omzet','MerchantController@omzet');
});


