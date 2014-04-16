$(document).ready(function() {

    var map;
    var markers = [];
    var lat;
    var long;
    
    // Set up the map, centered on London baby, yeah!
    function initialize() {       
        var mapOptions = {
            center: new google.maps.LatLng(51.508515,-0.12548719999995228),
            zoom: 15
        };        
        map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);       
    }
    
    google.maps.event.addDomListener(window, 'load', initialize);
    
    // On submission of a location, re-center the map and get crime data
    $('#location').submit(function(event) {
        event.preventDefault();
        var geocoder = new google.maps.Geocoder();
        var location = $(this).find('input').val();
        
        geocoder.geocode({ 'address' : location, 'componentRestrictions': {'country' : 'gb'} }, function(results, status) {            
           lat = results[0].geometry.location.lat();
           long = results[0].geometry.location.lng();
           map.setCenter(results[0].geometry.location);
           
           var data = { 'catUrl': 'all-crime', 'lat': lat, 'long': long };
        
            $.get('/get-crimes', data, function(data) {
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
    });
    
    // Get new crime data when crime category is changed
    $('#category').change(function() {
        clearMap();
        var catUrl = $(this).val();
        var data = { 'catUrl': catUrl, 'lat': lat, 'long': long };
        
        $.get('/get-crimes', data, function(data) {
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
    
      
    function clearMap()
    {
        for (var i=0; i<markers.length; i++) {
            markers[i].setMap(null);
        }
        markers = [];
    }
    
    
});

    



