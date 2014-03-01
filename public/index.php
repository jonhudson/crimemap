<?php

require '../vendor/autoload.php';

$app = new Slim\Slim(array(
    'debug' => true,
    'templates.path' => '../src/templates'
));

$app->catsToRemove = array('anti-social-behaviour', 'burglary', 'criminal-damage-arson', 'drugs', 'other-theft', 'robbery', 'public-order', 'posession-of-weapons');

$app->filterCats = $app->container->protect(function($element) use ($app)
{
    return in_array($element->category, $app->catsToRemove) ? false : true;  
});

$app->get('/', function() use($app) {
    
    
    //$filteredData = array_filter($crimesData, $app->filterCats);
    
    $app->render('home.php');
});

$app->get('/get-crimes', function() use($app) {
    
    $handle = curl_init('http://data.police.uk/api/crimes-street/violent-crimes?lat=51.46881&lng=-0.12544');
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($handle);
    curl_close($handle);
    
    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setBody($result);
});

$app->get('/cats', function() use($app) {
    
    $handle = curl_init('http://data.police.uk/api/crime-categories?date=2014-01');
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($handle);
    curl_close($handle);
    
    $cats = json_decode($result);
    
    $app->render('cats.php', array('cats' => $cats));
});





$app->run();


