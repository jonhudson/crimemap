<?php 

$app->get('/', function() use($app) {
    $handle = curl_init('http://data.police.uk/api/crime-categories');
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($handle);
    curl_close($handle);
    $cats = json_decode($result);
       
    $categoryUrl = isset($_SESSION['category']) ? $_SESSION['category'] : '';
        
    $app->render('home.php', array('cats' => $cats, 'selectedCatUrl' => $categoryUrl));
});


$app->post('/save-category', function() use($app) {
    $category = $app->request->post('category');
    if ($category) {
        if (ctype_alpha(str_replace('-', '', $category))) {
            $_SESSION['category'] = $category;            
        }
    }
    
   $app->response->redirect('/', 303); 
}); 


$app->get('/get-crimes', function() use($app) {
    if ($app->request->isAjax()) { 
        isset($_SESSION['category']) ? $category = $_SESSION['category'] : $category = 'all-crimes';
        
        $handle = curl_init('http://data.police.uk/api/crimes-street/' . urlencode($category) . '?lat=51.46881&lng=-0.12544');
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($handle);
        curl_close($handle);
        
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setBody($result);
    } else {
        $app->pass();
    }
});
