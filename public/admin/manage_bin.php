<?php
	require_once '../../includes/config.php';
	require_once LIB_PATH.DS.'Session.php';
	require_once LIB_PATH.DS.'Bin.php';
	require_once LIB_PATH.DS.'Area.php';
	if(!$session->isLoggedIn() || !$session->isAdmin()){
		$link = SITE_LINK.'admin/login.php';
		header("Location: {$link}");
	}
	$message = $session->getFlashValue('message');
	$allAreas = Area::findAll();
	$areas = [];
	foreach ($allAreas as $key => $area) {
		$areas[$area->id] = $area->name;
	}
	$allBins = Bin::findAll();
	$layout_context = 'admin';
	require_once LAYOUT_PATH.DS.'header.php';
?>

	<div id="main">
		<div id="navigation">
			<ul class="subjects">
				<li><a href="<?php echo SITE_LINK ?>">Home</a></li>
				<li><a href="index.php">&laquo; Main menu</a></li>
				<?php
					if($session->isAdmin()){
						require_once LAYOUT_PATH.DS.'admin_nav.php';
					}else{
						require_once LAYOUT_PATH.DS.'driver_nav.php';
					}
				?>
			</ul>
		</div>
		<div id="page">
			<h2>Manage Bins</h2>
			<?php
				if($message){
					echo '<div class="message">' . $message . '</div>';
				}
				if(empty($allBins)){
					echo '<div class="message"><h3>There are no Bins</h3></div>';
				}else{
			?>
			<table>
		    	<thead>
			      	<tr>
				        <th style="text-align: left">Name</th>
				        <th style="text-align: left">&nbsp;Area</th>
				        <th colspan="2" style="text-align: left;">&nbsp;Actions</th>
				    </tr>
				</thead>
				<tbody>
				    <?php
				    	foreach ($allBins as $key => $bin) {
				    ?>
			        <tr>
				        <td><?php echo htmlentities($bin->name) ?></td>
				        <td>&nbsp;
				        	<?php 
				        		echo isset($bin->areaId) ? htmlentities($areas[$bin->areaId]) : 'Not Yet Allocated';
				        	?>
				    	</td>
				        <!--<td>&nbsp;<a href="view_bin.php?id=<?php //echo urlencode($bin->id)?>">View</a></td>-->
				        <td>&nbsp;<a href="delete_bin.php?id=<?php echo urlencode($bin->id)?>" onclick="return confirm('Are you sure?');">Delete</a></td>
			      	</tr>
			    	<?php } } ?>
		        </tbody>
		    </table>
		    <a href="new_bin.php">Add a new bin</a>
		    <div style="width:100%;height:450px;background:grey" id="map"></div>
		</div>
		<div style="clear:both"></div>
	</div>
 <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB21v2YPxx7P8exkdxSuZYY8ifRZRf_uHA&callback=initMap"
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
			        //$markers .= 'label: "' . htmlentities($bin->name) .'",';
			        $markers .= 'label: "",';
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
<?php
	require_once LAYOUT_PATH.DS.'footer.php';
?>