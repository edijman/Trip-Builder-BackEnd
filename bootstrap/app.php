<?php
require 'vendor/autoload.php';
require $_SERVER['DOCUMENT_ROOT']. "/src/config/db.php";
require $_SERVER['DOCUMENT_ROOT']. "/src/model/flight.php";
$app = new \Slim\App([
    'settings' => 
    [
        'displayErrorDetails' => true,
    ]
]);

?>