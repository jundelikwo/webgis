<?php
	require_once LIB_PATH.DS.'Area.php';
	require_once LIB_PATH.DS.'Bin.php';
	require_once LIB_PATH.DS.'Session.php';
	$areas = Area::findAllByField('driverId',$session->getId());
	$areasId = '';
	$allBins = [];
	if($areas){
		$countAreas = count($areas);
		foreach ($areas as $key => $area) {
			$allBins = array_merge($allBins,Bin::findAllByField('areaId',$area->id));
		}
	}else{
		echo "<h3>You have not yet been allocated any bins";
	}
?>

<div style="width:100%;height:550px;background:grey;margin-top:10px" id="map"></div>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwO5hLv-bGYpOLUDyeM31YNHQbBRbc4Ak&callback=initMap"
type="text/javascript"></script>
<script>
	var directionsService
	var directionsDisplay
	var map
	function initMap() {
	  directionsService = new google.maps.DirectionsService();
	  var center = new google.maps.LatLng(4.9739, 8.3410);
	  var mapOptions = {
	    zoom:20,
	    center: center
	  }
	  map = new google.maps.Map(document.getElementById('map'), mapOptions);
	  //directionsDisplay.setMap(map);
	  directionsDisplay = new google.maps.DirectionsRenderer({ map: map, suppressMarkers: true });
	  calcRoute()
	}

	function calcRoute() {
	  var start = new google.maps.LatLng(4.952163,8.351585);
	  var end = new google.maps.LatLng(4.9739,8.3410);
	  startMarker = new google.maps.Marker({
            position: { lat: 4.952163, lng: 8.351585 },
            label: "You",
            map: map
      });
      endMarker = new google.maps.Marker({
            position: { lat: 4.9739, lng: 8.3410 },
            label: "Dump Site",
            map: map
      });
	  var request = {
	    origin: start,
	    destination: end,
	    travelMode: 'DRIVING',
	    waypoints: setWaypoints(),
	    optimizeWaypoints: true
	  };
	  directionsService.route(request, function(result, status) {
	    if (status == 'OK') {
	      directionsDisplay.setDirections(result);
	    }
	  });
	}
	var waypoints
	function setWaypoints(){
		<?php
			if($allBins){
				$waypoints = "waypoints=[";
				$markers = '';
				$binsCount = count($allBins);
				foreach ($allBins as $key => $bin) {
					$waypoints .= "{ location: new google.maps.LatLng(" . $bin->latitude ."," . $bin->longitude . ") , stopover: true }";
					$markers .= "new google.maps.Marker({position: {lat: ";
			        $markers .= $bin->latitude . ', lng:' . $bin->longitude . '},';
			        $markers .= 'label: "' . htmlentities($bin->name) .'",';
			        $markers .= 'map: map';
				    $markers .= "})\n";
					if($key !== $binsCount-1){
						$waypoints .= ',' ;
					}
				}
				$waypoints .= "]";
				echo $markers;
				echo "return " . $waypoints;
			}
		?>
	}
</script>