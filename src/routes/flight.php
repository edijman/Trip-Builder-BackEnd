<?php 
require $_SERVER['DOCUMENT_ROOT']. "/src/class/airport.php";
require $_SERVER['DOCUMENT_ROOT']. "/src/class/flight.php";

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app->get('/itinerary/{departure_city_id}/{arrival_city_id}/{departureDate}', function (Request $req, Response $res, array $args)
{

    $departure_city_id = $args['departure_city_id'];
    $arrival_city_id = $args['arrival_city_id'];
    $departureDate = $args['departureDate'];
    $db = new db();
    $db = $db->connect();

    $airport = new Airport();
    $flightO = new Flight();

    //get airport in the cities base on the city id
    $arriveCityCode = $airport->getCode($db, $arrival_city_id, 'arrival');
    $departCityCode = $airport->getCode($db, $departure_city_id, 'departure');
    
    //get Flight based on departure and arrival city code
    $flight = $flightO->getDirectFlight($db, $departCityCode, $arriveCityCode, $departureDate);
    $airline =[];

    //Get the airline for each flight
    for($i = 0; $i < count($flight); $i++ )
    {
        $airline = array_merge($airline, $flightO->getAirline($db, $flight[$i]['airline']));
        $airline = array_unique($airline, SORT_REGULAR);
    }

    $departureAirport = $airport->getAirport($db, $departCityCode);
    $arrivalAirport = $airport->getAirport($db, $arriveCityCode);
    $airports = array_merge($departureAirport, $arrivalAirport);

    $res->getBody()->write( '
            {
                "Airline":'.json_encode($airline).',
                "Flight":'.json_encode($flight).',
                "Airport":'.json_encode($airports).'
            }
    ');
});
?>