<?php

require '../vendor/autoload.php';

use CrimeMap\lib\Database;
use CrimeMap\Config;
use CrimeMap\models\CrimeModel;
use CrimeMap\lib\StatsHelper;

// Configure Slim
$app = new Slim\Slim(array(
    'debug' => true,
    'templates.path' => '../src/templates'
));

// Configure container
$app->container->singleton('db', function () {
    return new Database(Config::DB_HOST, Config::DB_NAME, Config::DB_USERNAME, Config::DB_PASSWORD);
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


