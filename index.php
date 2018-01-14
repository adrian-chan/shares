<?php
require_once ('bootstrap.php');

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Choccybiccy\Sentiment\Factory;

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

$app->get('/sentiment', function (Request $request, Response $response) {

        $sampleText = "Greencross Limited (ASX: GXL)

I’m a big fan of this integrated pet care company and believe it would be a great long-term investment. I’ve been impressed at the early success of its in-store clinic roll out and expect it to ultimately provide a strong return on investment. In-store clinics are currently found in 17% of its retail stores, but management is targeting over 60% in the future. This could help the company grow its dividend which currently provides a trailing fully franked 3% yield.

WAM Capital Limited (ASX: WAM)

This listed investment company has managed to increase its dividend each year for no less than eight years in a row. And thanks to the strong performance of its funds again this year I expect that WAM Capital will be in a position to make it nine years this year. At present its shares provide a trailing fully franked 6.1% dividend.";

        echo "<b>phpInsight</b>";
        $phpInsight = new \PHPInsight\Sentiment();
        $result["scores"]   = $phpInsight->score($sampleText);
        $result["dominant"] = $phpInsight->categorise($sampleText);

        var_dump($result);

        echo  "<b>DatumBox using choccybiccy/sentiment</b>";
        echo "<br/>";

/*        $datumBoxApiKey = '3c3373514674c94eb60f5f0e8d32c510';

        $datumBox = new Factory();
        $sentiment = $datumBox->create(
            Factory::ENDPOINT_ANALYSIS_SENTIMENT,
            $datumBoxApiKey
        );
         echo $sentiment->analyse($sampleText)->getResult();
        echo "<br/>";

         $sentiment = $datumBox->create(
            Factory::ENDPOINT_ANALYSIS_SUBJECTIVITY,
            $datumBoxApiKey
        );

        echo $sentiment->analyse($sampleText)->getResult();
          echo "<br/>";
        
         $sentiment = $datumBox->create(
            Factory::ENDPOINT_CLASSIFICATION_TOPIC,
            $datumBoxApiKey
        );
        echo $sentiment->classify($sampleText)->getResult();
        echo "<br/>";
*/
        

});

$app->get('/display', \Controllers\TestController::class . ':display');

$app->run();
?>