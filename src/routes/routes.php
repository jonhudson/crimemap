<?php 

$app->get('/', function() use($app) {
    $handle = curl_init('http://data.police.uk/api/crime-categories');
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($handle);
    curl_close($handle);
    $cats = json_decode($result);
        
    $app->render('home.php', array('cats' => $cats));
});


$app->get('/get-crimes/:catUrl', function($catUrl) use($app) {
    if ($app->request->isAjax()) { 
                
        $handle = curl_init('http://data.police.uk/api/crimes-street/' . urlencode($catUrl) . '?lat=51.702551&lng=0.110461');
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($handle);
        curl_close($handle);
        
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setBody($result);
    } else {
        $app->pass();
    }
});

