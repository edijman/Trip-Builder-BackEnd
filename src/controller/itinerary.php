<?php 
use Psr\Container\ContainerInterface;

class ItineraryController
{
   protected $container;

   // constructor receives container instance
   public function __construct(ContainerInterface $container) {
       $this->container = $container;
   }

   public function itinerary($request, $response, $args) {
    $departure_city_id = $args['departure_city_id'];
    $arrival_city_id = $args['arrival_city_id'];
    $departureDate = $args['departureDate'];

    $flightObj = new Flight();

    //get airport in the cities base on the city id
    $arriveCityCode = $flightObj->getCode($arrival_city_id, 'arrival');
    $departCityCode = $flightObj->getCode($departure_city_id, 'departure');
    
    // //get Flight based on departure and arrival city code
    $flight = $flightObj->getDirectFlight($departCityCode, $arriveCityCode, $departureDate);
    
    // //Get the airline for each flight
    $airlines = $this->getAirlines($flight, $flightObj);
    $airports = $this->getAirports($flightObj, $departCityCode, $arriveCityCode);

    $response->getBody()->write( 
        '
            {
                "Airline":'.json_encode($airlines).',
                "Flight":'.json_encode($flight).',
                "Airport":'.json_encode($airports).'
            }
        '
    );

    }

    // This method returns all the Airlines invlove in the flight
    function getAirlines($flight, $flightObj)
    {
        $airline =[];

        for($i = 0; $i < count($flight); $i++ )
        {
            $airline = array_merge($airline, $flightObj->getAirline($flight[$i]['airline']));
            $airline = array_unique($airline, SORT_REGULAR);
        }
        return $airline;
    }

    //This method returns all the Airport invlove in the flight
    function getAirports($flightObj, $departCityCode, $arriveCityCode)
    {
        $departureAirport = $flightObj->getAirport($departCityCode);
        $arrivalAirport = $flightObj->getAirport($arriveCityCode);
        $airports = array_merge($departureAirport, $arrivalAirport);
        return $airports;
    }
}

?>