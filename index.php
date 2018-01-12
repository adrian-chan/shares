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

//Route for sentiment analysis
$app->get('/sentiment', function (Request $request, Response $response) {

    $url = "http://forums.whirlpool.net.au/forum-replies.cfm?t=2619312";
    $client = new Goutte\Client();


    $content = $client->request('GET', $url);

    $text = "";
   // $content->filter('.comment-body > p')->each(function($node) use (&$text) {
    $content->filter('.bodytext p')->each(function($node) use (&$text) {
        $text .= $node->text();
    });

    //$text=$content->html();

    $sentiment = new \PHPInsight\Sentiment();

    $result["paragraph"] = $text;
    $result["sentiment"] = $sentiment->score($text);
    $result["category"] = $sentiment->categorise($text);

    var_dump($result);

});

$app->get('/display', \Controllers\TestController::class . ':display');

$app->run();
?>