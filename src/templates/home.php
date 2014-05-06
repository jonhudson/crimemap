<!DOCTYPE html>
<html class="height-100">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" href="/css/style.css" type="text/css">        
        <link rel="stylesheet" href="/css/bootstrap-theme.min.css" type="text/css">
        <link rel="stylesheet" href="/css/bootstrap.min.css" type="text/css">
    </head>
    <body class="height-100">
        <div class="container-fluid height-100">
            <div class="row height-100">
                <div class="col-xs-3">
                    <form id="crimeform">
                        <div class="form-group">
                            <label for="location">Enter location:</label>
                            <input type="text" name="location" id="location" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="category">Choose crime category:</label>
                            <select id="category" name="category" class="form-control">
                                <?php foreach($cats as $cat): ?>                    
                                    <option value="<?php echo $cat->url; ?>"><?php echo $cat->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>  
                        <div class="form-group">
                            <label for="year">Year:</label>
                            <select id="year" name="year" class="form-control">  
                                <?php $diff = date('Y') - 2011; $date = date('Y'); ?>
                                <?php for ($diff; $diff > 0; $diff--): ?>                  
                                <option value="<?php echo $date - $diff; ?>"><?php echo $date - $diff; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>                      
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>                    
                </div>
                <div class="col-xs-9 height-100">
                    <div id="map-canvas" class="height-100"></div>
                </div>
            </div>
        </div>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoJfc5hCodqzH1IXFrFiAW313_B8CnCTA&sensor=true&libraries=visualization"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="/js/map.js"></script>
    </body>
</html>
