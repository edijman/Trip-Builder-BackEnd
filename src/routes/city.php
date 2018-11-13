<?php 
require $_SERVER['DOCUMENT_ROOT']. "/src/class/city.php";
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/cities', function (Request $req, Response $res, array $args)
{
    $city = new City();
    $db = new db();
    $db = $db->connect();
    $cities = $city->getCities($db);
    $res->getBody()->write( '
    {
        "cities":'.json_encode($cities).'
    }
    ');
});

?>