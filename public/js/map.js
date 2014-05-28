$(document).ready(function() {

    var map;
    var markers = [];
    var lat;
    var long;
    var categorySelect = $('#category');
    
    // Set up the map, centered on London
    function initialize() {       
        var mapOptions = {
            center: new google.maps.LatLng(51.508515,-0.12548719999995228),
            zoom: 15
        };        
        map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);       
    }    
    google.maps.event.addDomListener(window, 'load', initialize);
    
    var heatmap;
    $('#crimeform').submit(function(event) {
        event.preventDefault();
        var geocoder = new google.maps.Geocoder();
        var location = $(this).find('#location').val();
        var category = $(this).find('#category').val();        
        
        if (heatmap) {
            heatmap.setMap(null);
        }        

        geocoder.geocode({ 'address' : location, 'componentRestrictions': {'country' : 'gb'} }, function(results, status) {            
            lat = results[0].geometry.location.lat();
            long = results[0].geometry.location.lng();
            map.setCenter(results[0].geometry.location);
           
            var data = { 'category': category, 'lat': lat, 'long': long };
            var heatmapData = [];
            if (category == 'All crime') {
                var uri = '/crimes/' + encodeURIComponent(lat) + '/' + encodeURIComponent(long);
            } else {
                var uri = '/crimes/' + encodeURIComponent(category) + '/'  + encodeURIComponent(lat) + '/' + encodeURIComponent(long);
            }
            $.get(uri, function(data) {
                if (data) {
                    for (var i = 0; i < data.length; i++) {                          
                        heatmapData[i] = new google.maps.LatLng(data[i].lat, data[i].lng);                      
                    }
                    
                    heatmap = new google.maps.visualization.HeatmapLayer({data: heatmapData});
                    var gradient = [
                        'rgba(0, 255, 255, 0)',
                        'rgba(0, 255, 255, 1)',
                        'rgba(0, 191, 255, 1)',
                        'rgba(0, 127, 255, 1)',
                        'rgba(0, 63, 255, 1)',
                        'rgba(0, 0, 255, 1)',
                        'rgba(0, 0, 223, 1)',
                        'rgba(0, 0, 191, 1)',
                        'rgba(0, 0, 159, 1)',
                        'rgba(0, 0, 127, 1)',
                        'rgba(63, 0, 91, 1)',
                        'rgba(127, 0, 63, 1)',
                        'rgba(191, 0, 31, 1)',
                        'rgba(255, 0, 0, 1)'
                      ];
                    heatmap.set('gradient', gradient);
                    heatmap.set('radius', 40);
                    heatmap.setMap(map);
                    
                }               
            }); 
        
        });        
    });
});

    



