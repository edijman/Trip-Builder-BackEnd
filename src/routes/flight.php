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

    $airportObj = new Airport();
    $flightObj = new Flight();

    //get airport in the cities base on the city id
    $arriveCityCode = $airportObj->getCode($db, $arrival_city_id, 'arrival');
    $departCityCode = $airportObj->getCode($db, $departure_city_id, 'departure');
    
    //get Flight based on departure and arrival city code
    $flight = $flightObj->getDirectFlight($db, $departCityCode, $arriveCityCode, $departureDate);
    
    //Get the airline for each flight
    $airlines = getAirlines($db, $flight, $flightObj);
    $airports = getAirports($db, $airportObj, $departCityCode, $arriveCityCode);

    $res->getBody()->write( '
            {
                "Airline":'.json_encode($airlines).',
                "Flight":'.json_encode($flight).',
                "Airport":'.json_encode($airports).'
            }
    ');
});

//This method returns all the Airlines invlove in the flight
function getAirlines($db, $flight, $flightObj)
{
    $airline =[];

    for($i = 0; $i < count($flight); $i++ )
    {
        $airline = array_merge($airline, $flightObj->getAirline($db, $flight[$i]['airline']));
        $airline = array_unique($airline, SORT_REGULAR);
    }
    return $airline;
}

//This method returns all the Airport invlove in the flight
function getAirports($db, $airportObj, $departCityCode, $arriveCityCode)
{
    $departureAirport = $airportObj->getAirport($db, $departCityCode);
    $arrivalAirport = $airportObj->getAirport($db, $arriveCityCode);
    $airports = array_merge($departureAirport, $arrivalAirport);
    return $airports;
}
?>