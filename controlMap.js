var lastOpenedMarker = null;
var map = null;
var directionsDisplay =null;

function initialize() {
	directionsDisplay = new google.maps.DirectionsRenderer();
	var latlng = new google.maps.LatLng(40.109713, -88.235783);
	var myOptions = {
		zoom : 15,
		center : latlng,
		mapTypeId : google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	directionsDisplay.setMap(map)
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
	
	if (typeof(navigator.geolocation) != 'undefined') {
		//alert(typeof(navigator.geolocation.getCurrentPosition));
	    //navigator.geolocation.getCurrentPosition(locationFound,errorCall,{timeout:10000});
	}
    
;
}
function setDirections(){
	if (typeof(navigator.geolocation) != 'undefined') {
		//alert(typeof(navigator.geolocation.getCurrentPosition));
	     navigator.geolocation.getCurrentPosition(locationFound,errorCall,{timeout:10000});
	}
}
function locationFound(position){
	
    var lat = position.coords.latitude;
    var lng = position.coords.longitude;
	//alert(String(position.coords.latitude)+ "  " + String(position.coords.longitude));
    var start = new google.maps.LatLng(lat, lng);
    var end = "706 South 5th St., Champaign, IL 61820";

	var request = {
		origin : start,
		destination : end,
		travelMode : google.maps.TravelMode.DRIVING
	};
	//alert(typeof(directionsDisplay.getMap()));
	var directionsService = new google.maps.DirectionsService();
	directionsService.route(request, function(result, status) {
		if(status == google.maps.DirectionsStatus.OK) {
			directionsDisplay.setDirections(result);
			var directionsPane = document.getElementById('directions');
			directionsPane.innerHTML="";
			directionsDisplay.setPanel(document.getElementById('directions'));
		}

	});
}
function errorCall(error){
	alert("no location found");
}

function listenmarker(marker, infowindow, map) {
	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map, this);
		if(lastOpenedMarker != null)
			lastOpenedMarker.close();
		lastOpenedMarker = infowindow;
	});
}