<?php

require '../vendor/autoload.php';

use CrimeMap\lib\Database;
use CrimeMap\Config;

$app = new Slim\Slim(array(
    'debug' => true,
    'templates.path' => '../src/CrimeMap/templates'
));

$app->container->singleton('db', function () {
    return new Database(Config::DB_HOST, Config::DB_NAME, Config::DB_USERNAME, Config::DB_PASSWORD);
});

require '../src/CrimeMap/routes/routes.php';

$app->run();


