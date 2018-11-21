<?php 

require $_SERVER['DOCUMENT_ROOT']. "/src/controller/itinerary.php";

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app->get('/itinerary/{departure_city_id}/{arrival_city_id}/{departureDate}', \ItineraryController::class . ':itinerary');
?> 