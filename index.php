<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
header("Access-Control-Allow-Origin: *");
require './vendor/autoload.php';
require $_SERVER['DOCUMENT_ROOT']. "/src/config/db.php";
$app = new \Slim\App;

require './src/routes/flight.php';
require './src/routes/city.php';

$app->run();