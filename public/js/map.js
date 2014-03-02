$(document).ready(function() {

    function initialize() {              
        
        var mapOptions = {
            center: new google.maps.LatLng(51.46881, -0.12544),
            zoom: 15
        };
        
        var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
        
        $.get('/get-crimes', function(data) {
            for (var i = 0; i < data.length; i++) {            
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(data[i].location.latitude, data[i].location.longitude),
                    map: map,
                    title: data[i].category,
                });
            }
        }); 
    }   
    
    google.maps.event.addDomListener(window, 'load', initialize);
});

    



