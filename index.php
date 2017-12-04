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

    $buyPrice = 1.00;
    $currentPrice = 2.00;

    echo (new \Classes\Projections())->gains($buyPrice, $currentPrice);
    echo "<br/>";
    echo (new \Classes\Projections())->gains(100, 300);
    echo "<br/ >";
    echo (new \Classes\Projections())->gains(100, 1000);
    //$test = new b;

//    $test = $this->get('ct');
//    $test->test();
    //var_dump($this->view);
    //var_dump($this->ct);
    //return $newResponse;
});

$app->get('/display', \Controllers\TestController::class . ':display');


$app->run();
?>