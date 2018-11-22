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
				        <td>&nbsp;<?php echo htmlentities($areas[$bin->areaId]) ?></td>
				        <td>&nbsp;<a href="view_bin.php?id=<?php echo urlencode($bin->id)?>">View</a></td>
				        <td>&nbsp;<a href="delete_bin.php?id=<?php echo urlencode($bin->id)?>" onclick="return confirm('Are you sure?');">Delete</a></td>
			      	</tr>
			    	<?php } } ?>
		        </tbody>
		    </table>
		    <a href="new_bin.php">Add a new bin</a>
		</div>
	</div>
<?php
	require_once LAYOUT_PATH.DS.'footer.php';
?>