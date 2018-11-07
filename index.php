<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
header("Access-Control-Allow-Origin: *");
require './vendor/autoload.php';

$app = new \Slim\App;
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});

$app->get('/itinerary/{departure}/{arrival}', function (Request $req, Response $res, array $args){
    $departure = $args['departure'];
    $arrival = $args['arrival'];
    $res->getBody()->write("Your are departing from $departure and arriving in $arrival");
});

$app->get('/cities', function (Request $req, Response $res, array $args){
    $res->getBody()->write( '{
    "cities": [
                {
                    "name": "asasa",
                    "Code": "AUN"
                }
              ]}
    ');
});


$app->run();