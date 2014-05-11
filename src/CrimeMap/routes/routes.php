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
        //$catUrl = $app->request->get('catUrl'); 
        $lat = $app->request->get('lat');   
        $long = $app->request->get('long');  
        //$year = $app->request->get('year');      
        
        $validCrimes = array();
        $id = 1;
        while ($returnedData = $app->crimeModel->getCrimesInBatches(50000, $id)) {
            foreach ($returnedData['crimeData'] as $crime) {
                if ($app->haversine->getDistanceInMiles($lat, $long, $crime['lat'], $crime['lng']) <= 5) {
                    $validCrimes[] = $crime;
                }
            }
            $id = $returnedData['nextId'];
        }       
              
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setBody(json_encode($validCrimes));
    } else {
        $app->pass();
    }
});

