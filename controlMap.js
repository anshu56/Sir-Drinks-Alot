var lastOpenedMarker = null;
function initialize() {
	var latlng = new google.maps.LatLng(40.109713, -88.235783);
	var myOptions = {
		zoom : 15,
		center : latlng,
		mapTypeId : google.maps.MapTypeId.ROADMAP
	};
	var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

	var xmlhttp;
	var geocoder = new google.maps.Geocoder();
	//document.getElementById('tb').value = ingr;
	if(window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {

			var jsondata = eval('(' + xmlhttp.responseText + ')');
			for(bar in jsondata.barsArray) {
				var latlng = new google.maps.LatLng(jsondata.barsArray[bar].Latitude, jsondata.barsArray[bar].Longitude)
				var title2 = jsondata.barsArray[bar].barName;
				var marker = new google.maps.Marker({
					map : map,
					position : latlng,
					title : title2
				});
				var contentString = jsondata.barsArray[bar].Description;

				var infowindow = new google.maps.InfoWindow({
					content : contentString
				});

				listenmarker(marker, infowindow, map);

				//alert(results[0].geometry.location);
			}
		}
	}
	xmlhttp.open("GET", "getBarsMapInfo.php", true);
	xmlhttp.send();

	var start = "510 East Clark St., Champaign, IL 61820";
	var end = "706 South 5th St., Champaign, IL 61820";
	var directionsDisplay = new google.maps.DirectionsRenderer();
	var directionsService = new google.maps.DirectionsService();
	directionsDisplay.setMap(map);
	var request = {
		origin : start,
		destination : end,
		travelMode : google.maps.TravelMode.WALKING
	};
	directionsService.route(request, function(result, status) {
		if(status == google.maps.DirectionsStatus.OK) {
			directionsDisplay.setDirections(result);
		}
	});
}

function listenmarker(marker, infowindow, map) {
	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map, this);
		if(lastOpenedMarker != null)
			lastOpenedMarker.close();
		lastOpenedMarker = infowindow;
	});
}