<?php

require '../vendor/autoload.php';

use CrimeMap\lib\Database;
use CrimeMap\Config;
use CrimeMap\models\CrimeModel;

// Configure Slim
$app = new Slim\Slim(array(
    'debug' => true,
    'templates.path' => '../src/CrimeMap/templates'
));


// Configure container
$app->container->singleton('db', function () {
    return new Database(Config::DB_HOST, Config::DB_NAME, Config::DB_USERNAME, Config::DB_PASSWORD);
});

$app->crimeModel = function() use ($app) {
    return new CrimeModel($app->db);
};

// Get routes
require '../src/CrimeMap/routes/routes.php';


// Run app
$app->run();


