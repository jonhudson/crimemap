<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" href="/css/style.css" type="text/css">
    </head>
    <body>
        <form id="location">
            <input type="text" name="location" />
            <select id="category" name="category">
                <?php foreach($cats as $cat): ?>                    
                    <option value="<?php echo $cat->url; ?>"><?php echo $cat->name; ?></option>
                <?php endforeach; ?>
            </select>
            <button>Submit</button>
        </form>
        
        <div id="map-canvas"></div>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoJfc5hCodqzH1IXFrFiAW313_B8CnCTA&sensor=true"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="/js/map.js"></script>
    </body>
</html>
