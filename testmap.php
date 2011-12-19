<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<style type="text/css">
  html { height: 100% }
  body { height: 100%; margin: 0; padding: 0 }
  #map_canvas { height: 100% }
</style>
<script 
src="http://maps.googleapis.com/maps/api/js?key=ABQIAAAAyeLpPg7oK__ZdP-CCrs57xQtJ3_mdHtcnfkdiGb4Eb2NzU-cqxR_9mKNOgUHKkEdeI3bDnFKDglo_A&sensor=true"
type="text/javascript"></script>
<script type="text/javascript">
  function initialize() {
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var myOptions = {
      zoom: 8,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("map_canvas"),
        myOptions);
  }

</script>
</head>
<body onload="initialize()">
  <div id="map_canvas" style="width:500px; height:500px"></div>
</body>
</html>