<?php
	require_once '../../includes/config.php';
	require_once LIB_PATH.DS.'Session.php';
	require_once LIB_PATH.DS.'Area.php';
	require_once LIB_PATH.DS.'User.php';

	if(!$session->isLoggedIn() || !$session->isAdmin()){
		$link = SITE_LINK.'admin/login.php';
		header("Location: {$link}");
	}
	$message = $session->getFlashValue('message');
	$allDrivers = User::findAllByField('role','driver');
	$drivers = [];
	foreach ($allDrivers as $key => $driver) {
		$drivers[$driver->id] = $driver->name;
	}
	$allAreas = Area::findAll();
	$layout_context = 'admin';
	require_once LAYOUT_PATH.DS.'header.php';
?>

	<div id="main">
		<div id="navigation">
			<ul class="subjects">
				<li><a href="<?php echo SITE_LINK ?>">Home</a></li>
				<li><a href="index.php">&laquo; Main menu</a></li>
				<?php
					require_once LAYOUT_PATH.DS.'admin_nav.php';
				?>
			</ul>
		</div>
		<div id="page">
			<h2>Manage Areas</h2>
			<?php
				if($message){
					echo '<div class="message">' . $message . '</div>';
				}
				if(empty($allAreas)){
					echo '<div class="message"><h3>There are no Areas</h3></div>';
				}else{
			?>
			<table>
      			<thead>
				  <tr>
				    <th style="text-align: left; width: 200px;">Name</th>
				    <th style="text-align: left; width: 200px;">Driver</th>
				    <th colspan="2" style="text-align: left;">Actions</th>
				  </tr>
				</thead>
				<tbody>
					<?php
				    	foreach ($allAreas as $key => $area) {
				    ?>
			        <tr>
				    	<td><?php echo substr(htmlentities($area->name),0,10) ?></td>
				    	<td>
				    		<?php
				    			if(array_key_exists($area->driverId, $drivers)){
				    				echo substr(htmlentities($drivers[$area->driverId]),0,10);
				    			}else{
				    				echo "Not yet allocated";
				    			}
				    		?>
				    	</td>
				        <td><a href="edit_area.php?id=<?php echo urlencode($area->id)?>">Edit</a></td>
				        <td><a href="delete_area.php?id=<?php echo urlencode($area->id)?>" onclick="return confirm('Are you sure?');">Delete</a></td>
				    </tr>
				    <?php } } ?>
        		</tbody>
    		</table>
    		<a href="new_area.php">Add a new area</a>
		</div>
	</div>
<?php
	require_once LAYOUT_PATH.DS.'footer.php';
?>