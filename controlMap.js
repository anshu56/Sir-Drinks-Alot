var lastOpenedMarker = null;
var map = null;
var directionsDisplay =null;
var distanceArray = new Array();
var markersArray = new Array();
var specificStore =null;
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
}
function setDirections(destType){
	clearOverlays();
	intializeLocations();
	if (typeof(navigator.geolocation) != 'undefined') {
		//alert(typeof(navigator.geolocation.getCurrentPosition));
		if(destType=='Bar')
  		navigator.geolocation.getCurrentPosition(locationFoundForBar,errorCall,{timeout:10000});
		else if(destType=='Store')
			navigator.geolocation.getCurrentPosition(locationFoundForStore,errorCall,{timeout:10000});
		else{
			if(destType!=null){
				specificStore=destType;
				navigator.geolocation.getCurrentPosition(locationFoundForSpecificStore,errorCall,{timeout:10000});
			}
		}
	}
}
function intializeLocations(){
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
				var closeArr = jsondata.barsArray[bar].Close.split(':');
				var openArr = jsondata.barsArray[bar].Open.split(':');
				var curTimeArr = (new Date()).toTimeString();
				curTimeArr = curTimeArr.split(' ')[0];	
				var curTime = curTimeArr;		
				curTimeArr = curTimeArr.split(':');
				var open = true;
				//past closing time
				//situation 1
				if(parseInt(openArr[0])>parseInt(closeArr[0]) || (parseInt(openArr[0])==parseInt(closeArr[0]) && parseInt(openArr[1])>parseInt(closeArr[1]))){
					if((parseInt(openArr[0])>curTimeArr[0] || (openArr[0]==curTimeArr[0] && openArr[1]>curTimeArr[1]))   && (parseInt(closeArr[0])<curTimeArr[0] || (closeArr[0]==curTimeArr[0] && closeArr[1]<=curTimeArr[1]))){
						open = false;
					}
				}
				else{//situation 2
					//easier to assume closed instead of having bunch of having more if statements because only 1 condition where open
					if((parseInt(openArr[0])<curTimeArr[0] || (openArr[0]==curTimeArr[0] && openArr[1]<=curTimeArr[1])) && (parseInt(closeArr[0])>curTimeArr[0] || (closeArr[0]==curTimeArr[0] && closeArr[1]<curTimeArr[1]))){
						open = true;
					}
					else{
						open = false;
					}
				}
				var contentString = jsondata.barsArray[bar].Description;
				contentString += "<div style='font-size:10px;'>";
				if(open){
					contentString += "Currently Open";
					contentString +="</br>";
					var closeTime;
					if(parseInt(closeArr[0])<=12){
						if(parseInt(closeArr[0])==0)
							closeTime='12';
						else
							closeTime = closeArr[0];
						closeTime+=':'+closeArr[1];
						if(closeArr[0]<12)
							closeTime+=" AM";
						else
							closeTime+=" PM";
					}
					else{
						closeTime = String(parseInt(closeArr[0])-12);
						closeTime += ":";
						closeTime+=" PM";
					}
					contentString+= "Closes at " + closeTime;
				}
				else{
					var openTime;
					if(parseInt(openArr[0])<=12){
						if(parseInt(openArr[0])==0)
							openTime='12';
						else
							openTime = openArr[0];
						openTime+=':'+openArr[1];
						if(openArr[0]<12)
							openTime+=" AM";
						else
							openTime+=" PM";
					}
					else{
						openTime = String(parseInt(openArr[0])-12);
						openTime += ":";
						openTime+=" PM";
					}
					contentString += "Currently Closed";
					contentString +="</br>";
					contentString+= "Opens at " + openTime;
				}
				contentString += "</div>";
				var specialsArray = jsondata.barsArray[bar].deals;
				contentString+="<table style='font-size:10px;'>";
				for(deal in specialsArray){
					contentString+="<tr><td>";
					if(specialsArray[deal].price!=null){
						if(specialsArray[deal].price==0){
							contentString += 'Free ';
						}
					
					else{
							if(Math.floor(parseFloat(specialsArray[deal].price)*10)== parseFloat(specialsArray[deal].price)*10 && Math.floor(parseFloat(specialsArray[deal].price))!= parseFloat(specialsArray[deal].price)){
								contentString += '$'+specialsArray[deal].price+'0';
								contentString += ' ';
							}else{
								contentString += '$'+specialsArray[deal].price;
								contentString += ' ';
							}
						
					}
}
					contentString += specialsArray[deal].deal;
					contentString+="</td></tr>";
				}
				contentString+="</table>";
				var infowindow = new google.maps.InfoWindow({
					content : contentString
				});

				listenmarker(marker, infowindow, map);

				//alert(results[0].geometry.location);
			}
			for(store in jsondata.liquorStoreArray) {
				var latlng = new google.maps.LatLng(jsondata.liquorStoreArray[store].Latitude, jsondata.liquorStoreArray[store].Longitude)
				var title2 = jsondata.liquorStoreArray[store].storeName;
				//alert(String(jsondata.liquorStoreArray[store].Latitude) + " " + String(jsondata.liquorStoreArray[store].Longitude));
				var marker = new google.maps.Marker({
					map : map,
					position : latlng,
					title : title2,
					icon: 'glass1.png'
				});
				var closeArr = jsondata.liquorStoreArray[store].Close.split(':');
				var openArr = jsondata.liquorStoreArray[store].Open.split(':');
				var curTimeArr = (new Date()).toTimeString();
				curTimeArr = curTimeArr.split(' ')[0];	
				var curTime = curTimeArr;		
				curTimeArr = curTimeArr.split(':');
				var open = true;
				//past closing time
				//situation 1
				if(parseFloat(openArr[0])>parseFloat(closeArr[0]) || (parseFloat(openArr[0])==parseFloat(closeArr[0]) && parseFloat(openArr[1])>parseInt(closeArr[1]))){
					if((parseFloat(openArr[0])>curTimeArr[0] || (openArr[0]==curTimeArr[0] && openArr[1]>curTimeArr[1]))   && (parseFloat(closeArr[0])<curTimeArr[0] || (closeArr[0]==curTimeArr[0] && closeArr[1]<=curTimeArr[1]))){
						open = false;
						alert("entered");
					}
				}
				else{//situation 2
					//easier to assume closed instead of having bunch of having more if statements because only 1 condition where open
					if((parseFloat(openArr[0])<curTimeArr[0] || (openArr[0]==curTimeArr[0] && openArr[1]<=curTimeArr[1])) && (parseFloat(closeArr[0])>curTimeArr[0] || (closeArr[0]==curTimeArr[0] && closeArr[1]<curTimeArr[1]))){
						open = true;
					}
					else{
						
						open = false;
					}
				}
				var contentString = jsondata.liquorStoreArray[store].storeName;
				contentString += "<div style='font-size:10px;'>";
				if(open){
					contentString += "Currently Open";
					contentString +="</br>";
					var closeTime;
					if(parseInt(closeArr[0])<=12){
						if(parseInt(closeArr[0])==0)
							closeTime='12';
						else
							closeTime = closeArr[0];
						closeTime+=':'+closeArr[1];
						if(closeArr[0]<12)
							closeTime+=" AM";
						else
							closeTime+=" PM";
					}
					else{
						closeTime = String(parseInt(closeArr[0])-12);
						closeTime += ":";
						closeTime+=" PM";
					}
					contentString+= "Closes at " + closeTime;
				}
				else{
					var openTime;
					
					if(parseFloat(openArr[0])<=12){
						if(parseFloat(openArr[0])==0)
							openTime='12';
						else
							openTime = openArr[0];
						openTime+=':'+openArr[1];
						if(openArr[0]<12)
							openTime+=" AM";
						else
							openTime+=" PM";
					}
					else{
						openTime = String(parseFloat(openArr[0])-12);
						openTime += ":";
						openTime+=" PM";
					}
					contentString += "Currently Closed";
					contentString +="</br>";
					contentString+= "Opens at " + openTime;
				}
				contentString += "</div>";
				var infowindow = new google.maps.InfoWindow({
					content : contentString
				});

				listenmarker(marker, infowindow, map);

				//alert(results[0].geometry.location);
			}
			//alert("claled");
		}
	}
	xmlhttp.open("GET", "getBarsMapInfo.php", true);
	xmlhttp.send();
}
function locationFoundForBar(position){
	locationFound(position,'Bar');
}
function locationFoundForStore(position){
	locationFound(position,'Store');
}
function locationFoundForSpecificStore(position){
  var lat = position.coords.latitude;
	var lng = position.coords.longitude;
	var start = new google.maps.LatLng(lat, lng);
	var xmlhttp;
	//document.getElementById('tb').value = ingr;
	if(window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange = function() {
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var jsondata = eval('(' + xmlhttp.responseText + ')');
			var storeArray = jsondata.storeArray[0];
			var end = storeArray.Address;
			var request = {
				origin : start,
				destination : end,
				travelMode : google.maps.TravelMode.DRIVING
			};
			
			var directionsService = new google.maps.DirectionsService();
			directionsService.route(request, function(result, status) {
				if(status == google.maps.DirectionsStatus.OK) {
						directionsDisplay.setDirections(result,{suppressMarkers: true});
						var directionsPane = document.getElementById('directions');
						directionsPane.innerHTML="";
						directionsDisplay.setPanel(directionsPane);
					
						var marker = new google.maps.Marker({
							    map: map,
							    position: start,
							    title : "Current Location"
						});
						var infowindow = new google.maps.InfoWindow({
									content : "currentLocation"
						});
						listenmarker(marker, infowindow, map);
				}
			});			
		}
	}
	xmlhttp.open("GET", "getStoreLocation.php?store="+specificStore, true);
	xmlhttp.send();
}
function locationFound(position,destType){
	
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
			var destArray;
			if(destType=='Bar'){
				destArray=jsondata.barsArray;
			}
			else if(destType=='Store'){
				destArray=jsondata.liquorStoreArray;
			}
			var numOfDest = destArray.length;
			distanceArray = new Array();
			for(x in destArray) {
				var end = destArray[x].Address;

				var request = {
					origin : start,
					destination : end,
					travelMode : google.maps.TravelMode.WALKING
				};
				var directionsService = new google.maps.DirectionsService();
				getDirectionsToClosest(directionsService, request,end,numOfDest,start);

			}
		}
	}
	xmlhttp.open("GET", "getBarsMapInfo.php", true);
	xmlhttp.send();
}
function getDirectionsToClosest(directionsService,request,address,numOfDest,startCoords){
		directionsService.route(request, function(result, status) {
			if(status == google.maps.DirectionsStatus.OK) {
				var myRoute = result.routes[0].legs[0];
				var distanceTuple = [myRoute.distance.value,myRoute.distance.text,address,result];
				distanceArray.push(distanceTuple);
				if(distanceArray.length==numOfDest){
					var minDist = 1000000000;
					
					var closestIndex;
					for(x in distanceArray){
						
						if(distanceArray[x][0]<minDist){
							minDist=distanceArray[x][0];
							closestIndex=x;
						}
					}
					directionsDisplay.setDirections(distanceArray[closestIndex][3],{suppressMarkers: true});
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
function clearOverlays() {
  if (markersArray) {
    for (i in markersArray) {
      markersArray[i].setMap(null);
    }
    markersArray=new Array();
  }
}
function listenmarker(marker, infowindow, map) {
	markersArray.push(marker);
	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map, this);
		if(lastOpenedMarker != null)
			lastOpenedMarker.close();
		lastOpenedMarker = infowindow;
	});
}
