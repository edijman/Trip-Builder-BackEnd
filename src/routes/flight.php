<?php 

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/itinerary/{departure_city_id}/{arrival_city_id}/{departureDate}', function (Request $req, Response $res, array $args)
{

    $departure_city_id = $args['departure_city_id'];
    $arrival_city_id = $args['arrival_city_id'];
    $departure_date = $args['departure_date'];
    $arrival_date = $args['arrival_date'];
    $departureDate = $args['departureDate'];


    //get airport in the cities base on the city id
    $arriveCityCode = getCode($arrival_city_id, 'arrival');
    $departCityCode = getCode($departure_city_id, 'departure');
    
    //get Flight based on departure and arrival city code
    $flight = getDirectFlight($departCityCode, $arriveCityCode, $departureDate);
    $airline =[];
    for($i = 0; $i < count($flight); $i++ )
    {
        $airline = array_merge($airline, getAirline($flight[$i]['airline']));
        $airline = array_unique($airline, SORT_REGULAR);
        // echo print_r($airline);
    }
    $departureAirport = getAirport($departCityCode);
    $arrivalAirport = getAirport($arriveCityCode);
    $airports = array_merge($departureAirport, $arrivalAirport);

    // echo $airline[0]["airline"];
    $res->getBody()->write( '
            {
                "Airline":'.json_encode($airline).',
                "Flight":'.json_encode($flight).',
                "Airport":'.json_encode($airports).'
                
            }
    ');
});

// getAirport
function getAirport($code)
{
    $sql = "SELECT * FROM trip.airports as airport INNER JOIN trip.city as city ON airport.code = :code AND airport.city_id = city.id" ; 
    try
    {
        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':code', $code);
        $stmt->execute();
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
    $sql = "SELECT name, code FROM trip.airlines as airline WHERE `name` = :name"; 
    try
    {
        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $airlines = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db = null;

        return $airlines;
        
    }
    catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
}

function getDirectFlight($departCityCode, $arriveCityCode, $departureDate)
{
    $sql = "SELECT * FROM trip.flights as flight WHERE `departure_airport` = :departCityCode AND `arrival_airport` = :arriveCityCode AND `departure_time` >= :departureDate AND `departure_time` < (:departureDate + INTERVAL 1 DAY) ORDER BY `price` ASC"; 
    try
    {
        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':departCityCode', $departCityCode);
        $stmt->bindParam(':arriveCityCode', $arriveCityCode);
        $stmt->bindParam(':departureDate', $departureDate);
        $stmt->execute();
        $flight = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db = null;

        return $flight;
        
    }
    catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
}


//get Airport code based on the city
function getCode($id, $tripType)
{
    if($tripType == 'arrival' )
    {
        $sql = "SELECT code FROM trip.airports as airport INNER JOIN trip.flights as flight ON airport.code = flight.arrival_airport  WHERE `city_id` = :id";
    }
    else if($tripType == 'departure')
    {
        $sql = "SELECT code FROM trip.airports as airport INNER JOIN trip.flights as flight ON airport.code = flight.departure_airport  WHERE `city_id` = :id"; 
    }
    try
    {
        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $Airport_code = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db = null;
        // echo 'Arrival'.$Airport_code[0]["code"];
        return $Airport_code[0]["code"];
        
    }
    catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }

    return 'Airport does not exist';

}


$app->get('/cities', function (Request $req, Response $res, array $args)
{
    $sql = "SELECT * FROM trip.city" ;
    try{
        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
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