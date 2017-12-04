<?php
require_once ('bootstrap.php');

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//$container = $app->getContainer();

// Register Twig View helper
$container = new \Slim\Container;
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/views');

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($c['router'], $basePath));

    return $view;
};

$container['ct'] = function ($container) {
    return new \Controller\TestController($container);
};

$app = new Slim\App($container);

$app->get('/', function () {
    echo "Test Assignment";
});


//ROUTE FOR BACKEND API CALL
$app->get('/home', function (Request $request, Response $response) {
    
    var_dump( (new \Classes\Projections())
        ->setBuyPrice(4.18)
        ->calculateNumberShares(500)
        ->setBuySellCost(19.95, 19.95)
        ->time_series(4.00, 4.60, 0.01) );
});

$app->get('/display', \Controllers\TestController::class . ':display');

$app->run();
?>