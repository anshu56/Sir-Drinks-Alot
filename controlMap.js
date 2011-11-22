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

				google.maps.event.addListener(marker, 'click', function() {
					infowindow.open(map, marker);
				});
				//alert(results[0].geometry.location);
			}
		}
	}
	xmlhttp.open("GET", "getBarsMapInfo.php", true);
	xmlhttp.send();
	/*var address = "706 South 5th St., Champaign, IL 61820";

	 var geocoder = new google.maps.Geocoder();

	 geocoder.geocode( { 'address': address}, function(results, status) {
	 if (status == google.maps.GeocoderStatus.OK) {
	 var marker = new google.maps.Marker({
	 map: map,
	 position: results[0].geometry.location,
	 title:"Joe's Brewery"
	 });
	 var contentString = "Joe's Bar";

	 var infowindow = new google.maps.InfoWindow({
	 content: contentString
	 });

	 google.maps.event.addListener(marker, 'click', function() {
	 infowindow.open(map,marker);
	 });
	 //alert(results[0].geometry.location);
	 } else {
	 alert("Geocode was not successful for the following reason: " + status);
	 }
	 });*/

}