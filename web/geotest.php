 <html> 
<head> 
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
  <title>Google Maps Multiple Markers</title> 
  <script src="http://maps.google.com/maps/api/js?sensor=false" 
          type="text/javascript"></script>
</head> 
<body>
  </br></br>
  <center><div id="map" style="width: 1024px; height: 768px;"></div></center>

	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script type="text/javascript">

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: new google.maps.LatLng(43.1547, -77.6158),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    setTimeout(function () {
        loadData(); 
    },500);


    function loadData()
    {
        //alert("Loading"); 
        var marker, i;

        var url = "http://mcsafetyfeed.org/api/getgeo.php";
        var name;
        var lat;
        var lon;
        var locations;

        $.getJSON(url, function (response) {handleData(response)});
    }

    function handleData(response)
    {
        //alert(response);
        var n;
        for(n=0; n<response.length; n++)
        {
            //name = response.drivers[n].name;
            //alert(name);
            lat = response[n].lat;
            lng = response[n].lng;
			event = response[n].event;
            var myLatLng = new google.maps.LatLng(lat,lng);
            var marker = new google.maps.Marker({
                position: myLatLng,
                //shadow: shadow,
                //icon:image,
                map: map,
                title: event,
                zIndex: 1
            });
        }   
    }



  </script>
</body>
</html>