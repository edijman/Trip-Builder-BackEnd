<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
header("Access-Control-Allow-Origin: *");
require './vendor/autoload.php';
require __DIR__. '/bootstrap/app.php';

require $_SERVER['DOCUMENT_ROOT']. "/src/routes/city.php";
require $_SERVER['DOCUMENT_ROOT']. "/src/routes/flight.php";

//Default Routes
$app->get('/', function (Request $req,  Response $res, $args = []) {
    return $res->withStatus(400)->write('Bad Request');
});


$app->run();