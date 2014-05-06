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
        $year = $app->request->get('year');
        $months = array('01','02','03','04','05','06','07','08','09','10','11','12');
        $data = array();
        
        foreach ($months as $month) {
            $date = $year . '-' . $month;
            $handle = curl_init('http://data.police.uk/api/crimes-street/' . urlencode($catUrl) . '?lat=' . urlencode($lat) . '&lng=' . urlencode($long) . '&date=' . urlencode($date));
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($handle);
            curl_close($handle);
            $data = array_merge_recursive($data, json_decode($result, true));
        }
              
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setBody(json_encode($data));
    } else {
        $app->pass();
    }
});

