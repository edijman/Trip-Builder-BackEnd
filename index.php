<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
header("Access-Control-Allow-Origin: *");
require './vendor/autoload.php';
require './src/config/db.php';
$app = new \Slim\App;
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});

$app->get('/itinerary/{departure_city_id}/{arrival_city_id}', function (Request $req, Response $res, array $args){

    $departure_city_id = $args['departure_city_id'];
    $arrival_city_id = $args['arrival_city_id'];
    $departure_date = $args['departure_date'];
    $arrival_date = $args['arrival_date'];
    $trip_type = $args['trip_type'];

    //get airport in the cities base on the city id

    $arriveCityCode = (string)getCode($arrival_city_id);
    $departCityCode = (string)getCode($departure_city_id);
    
    $flight = getFlight($departCityCode, $arriveCityCode);
    $airline = getAirline($flight[0]['airline']);
    // echo $airline[0]["airline"];
    $res->getBody()->write( '
            {
                "Airline":'.json_encode($airline).',
                "flights":'.json_encode($flight).'
                
            }
    ');

});

// getAirport

//get airline from name
function getAirline($name){
    $sql = "SELECT name, code FROM trip.Airlines as airline WHERE `name` = '$name'"; 
    try{
        $db = new db();
        $db = $db->connect();
        $stmt = $db->query($sql);
        $airlines = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db = null;

        return $airlines;
        
    }
    catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
}
function getFlight($departCityCode, $arriveCityCode){

    $sql = "SELECT * FROM trip.Flights as flight WHERE `departure_airport` = '$departCityCode' AND `arrival_airport` = '$arriveCityCode'"; 
    try{
        $db = new db();
        $db = $db->connect();
        $stmt = $db->query($sql);
        $flight = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db = null;

        return $flight;
        
    }
    catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
}


//get Airport code based on the city
function getCode($id){
    $sql = "SELECT * FROM trip.Airports WHERE `city_id` = $id"; 
    try{
        $db = new db();
        $db = $db->connect();
        $stmt = $db->query($sql);
        $Airport_code = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db = null;
        return $Airport_code[0]["code"];
        
    }
    catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }

    return 'Airport does not exist';

}


$app->get('/cities', function (Request $req, Response $res, array $args){

    $sql = "SELECT city.name FROM trip.City" ;
    try{
        $db = new db();
        $db = $db->connect();
        $stmt = $db->query($sql);
        $cities = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        $res->getBody()->write( '{
            "cities":'.json_encode($cities).'}
            ');
    }
    catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
    
});



$app->run();