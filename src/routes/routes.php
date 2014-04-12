<?php 

$app->get('/', function() use($app) {
    $handle = curl_init('http://data.police.uk/api/crime-categories');
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($handle);
    curl_close($handle);
    $cats = json_decode($result);
        
    $app->render('home.php', array('cats' => $cats));
});


$app->get('/get-crimes', function() use($app) {
    if ($app->request->isAjax()) { 
        $catUrl = $app->request->get('catUrl'); 
        $lat = $app->request->get('lat');   
        $long = $app->request->get('long');   
        
        $handle = curl_init('http://data.police.uk/api/crimes-street/' . urlencode($catUrl) . '?lat=' . urlencode($lat) . '&lng=' . urlencode($long));
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($handle);
        curl_close($handle);
        
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setBody($result);
    } else {
        $app->pass();
    }
});

