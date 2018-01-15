<?php

require_once ('vendor/autoload.php');

$config = [
    'settings' => [
        'displayErrorDetails' => true
    ]
];

//LOAD DOTENV WITH PHPDOTENV
$dotenv = new \Dotenv\Dotenv(__DIR__ . "/config", '.env');
$dotenv->load();

?>