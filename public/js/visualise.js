$(document).ready(function() {
    $('#visualiseform').submit(function(event) {
        event.preventDefault();
        var geocoder = new google.maps.Geocoder();
        var location = $(this).find('#location').val();
        var category = $(this).find('#category').val();        
        
        geocoder.geocode({ 'address' : location, 'componentRestrictions': {'country' : 'gb'} }, function(results) {            
            lat = results[0].geometry.location.lat();
            long = results[0].geometry.location.lng();
           
            var data = { 'category': category, 'lat': lat, 'long': long };
            
            if (category === 'All crime') {
                var uri = '/crimes-per-month/' + encodeURIComponent(lat) + '/' + encodeURIComponent(long);
            } else {
                var uri = '/crimes-per-month/' + encodeURIComponent(category) + '/'  + encodeURIComponent(lat) + '/' + encodeURIComponent(long);
            }
            $.get(uri, function(data) {
                if (data) {  
                    
                }
            });
        });
    });
});

