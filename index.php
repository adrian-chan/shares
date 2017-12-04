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

        $cwy = (new \Classes\Shares('GSW', 'Get Swift'))
                ->setPrice(4.18)
                ->setCapital(500);




        $cwy_projection = (new \Classes\Projections($cwy))
                    ->setCurrentPrice(4.32)
                    ->setBuySellCost(19.95, 19.95);

        var_dump($cwy_projection->time_series(4.18, 4.35, 0.01));

        var_dump( $cwy_projection->projectPercent(-3.990000));
        var_dump( $cwy_projection->projectPercent(-5));
    });

$app->get('/display', \Controllers\TestController::class . ':display');

$app->run();
?>