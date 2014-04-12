$(document).ready(function() {

    var map;
    var markers = [];
    
    function initialize() {       
        var mapOptions = {
            center: new google.maps.LatLng(51.702551,0.110461),
            zoom: 5
        };
        
        map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
        
        
    }
    
    
    $('#location').submit(function(event) {
        event.preventDefault();
        var geocoder = new google.maps.Geocoder();
        var location = $(this).find('input').val();
        geocoder.geocode({ 'address' : location }, function(results, status) {
           map.setCenter(results[0].geometry.location);
        });
        
        $.get('/get-crimes/all-crime', function(data) {
            for (var i = 0; i < data.length; i++) {            
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(data[i].location.latitude, data[i].location.longitude),
                    map: map,
                    title: data[i].category
                });
                markers.push(marker);
            }
        }); 
        
    });
    
    $('#category').change(function() {
        clearMap();
        var catUrl = $(this).val();
        $.get('/get-crimes/' + catUrl, function(data) {
            for (var i = 0; i < data.length; i++) {            
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(data[i].location.latitude, data[i].location.longitude),
                    map: map,
                    title: data[i].category
                });
                markers.push(marker);
            }
        });
    });
    
    google.maps.event.addDomListener(window, 'load', initialize);
    
    function setMarkers(map)
    {
        for (var i=0; i<markers.length; i++) {
            markers[i].setMap(map);
        }
    }
    
    function clearMap()
    {
        setMarkers(null);
        markers = [];
    }
    
    
});

    



