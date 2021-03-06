<?php 

$app->get('/', function() use($app) {    
    $categories = $app->crimeModel->getCategories();
    array_unshift($categories, array('crime_type' => 'All crime'));
    
    $app->render('home.php', array('categories' => $categories));
});

/**
 * Get all crimes within 1 mile of $lat and $long
 */
$app->get('/crimes/:lat/:long', function($lat, $long) use($app) {
    if ($app->request->isAjax()) {         
        $validCrimes = $app->crimeModel->getCrimes($lat, $long);             
              
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setBody(json_encode($validCrimes));
    } else {
        $app->pass();
    }
});

/**
 * Get all crimes within given category and within 1 mile of $lat and $long
 */
$app->get('/crimes/:category/:lat/:long', function($category, $lat, $long) use($app) {
    if ($app->request->isAjax()) {
        $validCrimesInCategory = $app->crimeModel->getCrimesInCategory($category, $lat, $long);             
              
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setBody(json_encode($validCrimesInCategory));
    } else {
        $app->pass();
    }
});

/**
 * Routes for charts section
 */

$app->get('/visualise', function() use($app) {
    $categories = $app->crimeModel->getCategories();
    array_unshift($categories, array('crime_type' => 'All crime'));
    
    $app->render('visualise.php', array('categories' => $categories));
});


$app->get('/crimes-per-month/:lat/:long', function($lat, $long) use ($app) {
    if ($app->request->isAjax()) {
        $crimesPerMonth = $app->crimeModel->getCrimeNumbersPerMonth($lat, $long);             
        $percentageChange = $app->statsHelper->getPercentageChange(array_sum($crimesPerMonth['2011']), array_sum($crimesPerMonth['2013']));
        
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setBody(json_encode(array(
            'crimes' => $crimesPerMonth,
            'change' => $percentageChange
            )
        ));
    } else {
        $app->pass();
    }
});

$app->get('/crimes-per-month/:category/:lat/:long', function($category, $lat, $long) use ($app) {
    if ($app->request->isAjax()) {
        $crimesPerMonthInCat = $app->crimeModel->getCrimeNumbersPerMonthInCat($category, $lat, $long);             
              
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setBody(json_encode($crimesPerMonthInCat));
    } else {
        $app->pass();
    }
});