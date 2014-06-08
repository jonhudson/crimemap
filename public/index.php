<?php

require '../vendor/autoload.php';

use CrimeMap\models\CrimeModel;
use CrimeMap\lib\StatsHelper;
use CrimeMap\lib\DBFactory;

// Configure Slim
$app = new Slim\Slim(array(
    'debug' => true,
    'templates.path' => '../src/templates'
));

// Configure container
$app->container->singleton('db', function () {
    return DBFactory::createDB('mysql');
});

$app->crimeModel = function() use ($app) {
    return new CrimeModel($app->db);
};

$app->statsHelper = function() use ($app) {
    return new StatsHelper;
};

// Get routes
require '../src/routes/routes.php';


// Run app
$app->run();


