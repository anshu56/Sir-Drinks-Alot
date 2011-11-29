var lastOpenedMarker = null;
var map = null;
var directionsDisplay =null;
var distanceArray = new Array();

function initialize() {
	directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers:true});
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
					title : title2,
					icon: 'beer2.png'
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
  var start = new google.maps.LatLng(lat, lng);
  var xmlhttp;
	if(window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var jsondata = eval('(' + xmlhttp.responseText + ')');
			var numBars = jsondata.barsArray.length;
			distanceArray = new Array();
			for(bar in jsondata.barsArray) {
				var end = jsondata.barsArray[bar].Address;
				var request = {
					origin : start,
					destination : end,
					travelMode : google.maps.TravelMode.WALKING
				};
				var directionsService = new google.maps.DirectionsService();
				getDirections(directionsService, request,jsondata.barsArray[bar].barName,end,numBars,start);

			}
		}
	}
	xmlhttp.open("GET", "getBarsMapInfo.php", true);
	xmlhttp.send();
}
function getDirections(directionsService,request,barName,barAddress,numBars,startCoords){
		directionsService.route(request, function(result, status) {
			if(status == google.maps.DirectionsStatus.OK) {
				var myRoute = result.routes[0].legs[0];
				var distanceTuple = [barName,myRoute.distance.value,myRoute.distance.text,barAddress,result];
				distanceArray.push(distanceTuple);
				if(distanceArray.length==numBars){
					var minDist = 1000000000;
					
					var closestIndex;
					for(bar in distanceArray){
						
						if(distanceArray[bar][1]<minDist){
							minDist=distanceArray[bar][1];
							closestIndex=bar;
						}
					}
					directionsDisplay.setDirections(distanceArray[closestIndex][4],{suppressMarkers: true});
					var directionsPane = document.getElementById('directions');
					directionsPane.innerHTML="";
					directionsDisplay.setPanel(directionsPane);
					
					var geocoder = new  google.maps.Geocoder();
					var marker = new google.maps.Marker({
					      map: map,
					      position: startCoords,
					      title : "Current Location"
				  });
				  var infowindow = new google.maps.InfoWindow({
								content : "currentLocation"
					});
					listenmarker(marker, infowindow, map);
				}
			}
		});
}
function getDistance(directionsResult){

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
