<?php
	require_once '../../includes/config.php';
	require_once LIB_PATH.DS.'Session.php';
	require_once LIB_PATH.DS.'Bin.php';
	require_once LIB_PATH.DS.'Area.php';

	if(!$session->isLoggedIn() || !$session->isAdmin()){
		$link = SITE_LINK.'admin/login.php';
		header("Location: {$link}");
	}

	if($_SERVER['REQUEST_METHOD'] === "POST" ){
        $name = $_POST['name'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $area = isset($_POST['area']) ? $_POST['area'] : null;
        $area = empty($area) ? null : $area;
        $newBin = new Bin;
        $newBin->name = $name;
        $newBin->latitude = $latitude;
        $newBin->longitude = $longitude;
        $newBin->areaId = $area;
        var_dump($newBin);
        $newBin->save();
        $session->flash('message', 'Bin successfully created');
        header("Location: manage_bin.php");
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
		<form action="new_bin.php" method="post">
	    	<p>Name:
		        <input type="text" name="name" value="" required>
		    </p>
		    <p>Longitude:
		        <input type="text" name="longitude" value="" required>
		    </p>
		    <p>Latitude:
		        <input type="text" name="latitude" value="" required>
		    </p>
		    <?php
		    	if(!empty($allAreas)){
		    ?>
		    <p>Assign To area:
		    	<select name="area">
		    		<option value="0">Not Now</option>
		    		<?php
		    			foreach ($allAreas as $key => $area) {
		    				echo "<option value='" . $area->id . "'>" . htmlentities($area->name) . "</option>";
		    			}
		    		?>
		    	</select>
		    </p>
		    <?php } ?>
		    <input type="submit" name="submit" value="Create Bin">
	    </form>
	    <br><a href="manage_bin.php">Cancel</a>
	</div>
</div>

<?php
	require_once LAYOUT_PATH.DS.'footer.php';
?>