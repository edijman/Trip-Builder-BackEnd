<?php 
use Psr\Container\ContainerInterface;

class CityController
{
   protected $container;

   // constructor receives container instance
   public function __construct(ContainerInterface $container) {
       $this->container = $container;
   }

   public function cities($request, $response, $args) {
    $flightObj = new Flight();
    $cities = $flightObj->getCities();
    $response->getBody()->write( '
    {
        "cities":'.json_encode($cities).'
    }
    ');
    }

}

?>