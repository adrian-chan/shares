<?php

require_once ('vendor/autoload.php');

$config = [
    'settings' => [
        'displayErrorDetails' => true
    ]
];

//LOAD DOTENV WITH PHPDOTENV
//check if file exists needed here
try {
    $dotenv = new \Dotenv\Dotenv(__DIR__ . "/config", '.env');
    $dotenv->load();
}
catch (Exception $e) {
    print $e->getMessage();
}
?>