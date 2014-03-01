<?php

require '../vendor/autoload.php';

$app = new Slim\Slim(array(
    'debug' => true,
    'templates.path' => '../src/templates'
));

$app->get('/', function() use($app) {
    
    $app->render('home.php');
});

$app->get('/get-crimes', function() use($app) {
    
    $handle = curl_init('http://data.police.uk/api/crimes-street/violent-crime?lat=51.46881&lng=-0.12544');
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($handle);
    curl_close($handle);
    
    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setBody($result);
});


$app->run();


