<?php
require_once ('bootstrap.php');

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//$container = $app->getContainer();

// Register Twig View helper
$container = new \Slim\Container;
$container['view'] = function ($container) {

    $view = new \Slim\Views\Twig(__DIR__ . '/Views');

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};

$container['ct'] = function ($container) {
    return new \Controller\TestController($container);
};

$app = new Slim\App($container);

$app->get('/', function ($request, $response, $args) {

    $test = "this is a test of slim configuration";
    $args["test"] = $test;
    $args["env"] = getenv("APP_ENV");
    var_dump($args);
    $this->view->render($response, 'test.twig', $args);
});


//ROUTE FOR BACKEND API CALL
$app->get('/home', function (Request $request, Response $response) {

    $cwy = (new \Classes\Shares('PLS', 'Pilbara minerals'))
        ->setPrice(1.18)
        ->setCapital(500);


    $cwy_projection = (new \Classes\Projections($cwy))
        ->setCurrentPrice(1.20)
        ->setBuySellCost(19.95, 19.95);

    var_dump($cwy_projection->time_series(1.10, 2.00, 0.01));

    var_dump( $cwy_projection->projectPercent(0));
    var_dump( $cwy_projection->breakEvenPrice());
    
});

$app->get('/quantcast', function ($request, $response) {

 //$response   $url

});

$app->get('/display', \Controllers\TestController::class . ':display');

$app->run();
?>