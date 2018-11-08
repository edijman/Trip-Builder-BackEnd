<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
header("Access-Control-Allow-Origin: *");
require './vendor/autoload.php';
require './src/config/db.php';
$app = new \Slim\App;

require './src/routes/flight.php';
$app->run();