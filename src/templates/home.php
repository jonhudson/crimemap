<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" href="/css/style.css" type="text/css">
    </head>
    <body>
        <form action="/save-category" method="POST">
            <select name="category">
                <?php foreach($cats as $cat): ?>                    
                    <?php $selected = ($selectedCatUrl == $cat->url) ? 'selected' : ''; ?>
                    <option value="<?php echo $cat->url; ?>" <?php echo $selected; ?>><?php echo $cat->name; ?></option>
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
