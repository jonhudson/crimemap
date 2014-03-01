<!DOCTYPE html>
<html>
    <head>  
        <style type="text/css">
          html { height: 100% }
          body { height: 100%; margin: 0; padding: 0 }
          #map-canvas { height: 100% }
        </style>
    </head>
    <body>
        <div id="map-canvas"></div>
        <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoJfc5hCodqzH1IXFrFiAW313_B8CnCTA&sensor=true">
        </script>
        <script type="text/javascript">
           
          $.get('/get-crimes', function(data) {
            for (var i = 0; i < data.length; i++) {
                
            }
          });  
            
          function initialize() {
              
            var mapOptions = {
              center: new google.maps.LatLng(51.46881, -0.12544),
              zoom: 14
            };
            
            var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
            
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(51.46881, -0.12544),
                map: map,
                title: "Stockwell",
            });
          
          }
          google.maps.event.addDomListener(window, 'load', initialize);
          
          
          
        </script>
        <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    </body>
</html>
