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
                    var chartData = {
                        labels : ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        datasets : [
                            {
                                fillColor : "rgba(255,0,127,0.5)",
                                strokeColor : "#679b00",
                                pointColor : "#679b00",
                                pointStrokeColor : "#fff",
                                data : [data['crimes']["2011"]["01"],data['crimes']["2011"]["02"],data['crimes']["2011"]["03"],data['crimes']["2011"]["04"],data['crimes']["2011"]["05"],data['crimes']["2011"]["06"],data['crimes']["2011"]["07"],data['crimes']["2011"]["08"],data['crimes']["2011"]["09"],data['crimes']["2011"]["10"],data['crimes']["2011"]["11"],data['crimes']["2011"]["12"]]
                            },
                            {
                                fillColor : "rgba(159,238,0,0.5)",
                                strokeColor : "#679b00",
                                pointColor : "#679b00",
                                pointStrokeColor : "#fff",
                                data : [data['crimes']["2012"]["01"],data['crimes']["2012"]["02"],data['crimes']["2012"]["03"],data['crimes']["2012"]["04"],data['crimes']["2012"]["05"],data['crimes']["2012"]["06"],data['crimes']["2012"]["07"],data['crimes']["2012"]["08"],data['crimes']["2012"]["09"],data['crimes']["2012"]["10"],data['crimes']["2012"]["11"],data['crimes']["2012"]["12"]]
                            },
                            {
                                fillColor : "rgba(0,153,153,0.5)",
                                strokeColor : "#006363",
                                pointColor : "#006363",
                                pointStrokeColor : "#fff",
                                data : [data['crimes']["2013"]["01"],data['crimes']["2013"]["02"],data['crimes']["2013"]["03"],data['crimes']["2013"]["04"],data['crimes']["2013"]["05"],data['crimes']["2013"]["06"],data['crimes']["2013"]["07"],data['crimes']["2013"]["08"],data['crimes']["2013"]["09"],data['crimes']["2013"]["10"],data['crimes']["2013"]["11"],data['crimes']["2013"]["12"]]
                            }
                        ]
                    };
                    var ctx = document.getElementById("line-chart").getContext("2d");
                    new Chart(ctx).Line(chartData);
                    $("#graph-container").after("<p>" + category + " went " + data['change']['direction'] + " by " + Math.abs(data['change']['percentage']) + "percent</p>");
                }
            });
        });
    });
});

