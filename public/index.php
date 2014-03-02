<?php
session_cache_limiter(false);
session_start();

require '../vendor/autoload.php';

$app = new Slim\Slim(array(
    'debug' => true,
    'templates.path' => '../src/templates'
));

require '../src/routes/routes.php';

$app->run();


