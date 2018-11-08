<?php 

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/itinerary/{departure_city_id}/{arrival_city_id}', function (Request $req, Response $res, array $args){

    $departure_city_id = $args['departure_city_id'];
    $arrival_city_id = $args['arrival_city_id'];
    $departure_date = $args['departure_date'];
    $arrival_date = $args['arrival_date'];
    $trip_type = $args['trip_type'];

    //get airport in the cities base on the city id
    $arriveCityCode = getCode($arrival_city_id);
    $departCityCode = getCode($departure_city_id);
    
    //get Flight based on departure and arrival city code
    $flight = getFlight($departCityCode, $arriveCityCode);
    $airline = getAirline($flight[0]['airline']);
    $departureAirport = getAirport($departCityCode);
    $arrivalAirport = getAirport($arriveCityCode);
    $airports = array_merge($departureAirport, $arrivalAirport);

    // echo $airline[0]["airline"];
    $res->getBody()->write( '
            {
                "Airline":'.json_encode($airline).',
                "flights":'.json_encode($flight).',
                "Airport":'.json_encode($airports).'
                
            }
    ');

});

// getAirport
function getAirport($code)
{
    $sql = "SELECT * FROM trip.Airports as airport INNER JOIN trip.city as city ON airport.code = '$code' AND airport.city_id = city.id" ; 
    try{
        $db = new db();
        $db = $db->connect();
        $stmt = $db->query($sql);
        $airport = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db = null;
        return $airport;
        
    }
    catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
}

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
?>