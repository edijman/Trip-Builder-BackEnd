<?php 
require $_SERVER['DOCUMENT_ROOT']. "/src/controller/city.php";
$app->get('/cities', \CityController::class . ':cities');

?>