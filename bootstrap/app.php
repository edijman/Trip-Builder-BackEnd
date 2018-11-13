<?php
require 'vendor/autoload.php';
require 'src/config/db.php';

$app = new \Slim\App([
    'settings' => 
    [
        'displayErrorDetails' => true,
    ]
]);

?>