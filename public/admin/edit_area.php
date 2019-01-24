<?php
	require_once '../../includes/config.php';
	require_once LIB_PATH.DS.'Session.php';
	require_once LIB_PATH.DS.'Area.php';
	require_once LIB_PATH.DS.'User.php';

	if(!$session->isLoggedIn() || !$session->isAdmin()){
		$link = SITE_LINK.'admin/login.php';
		header("Location: {$link}");
	}

	$area = Area::findById($_GET['id']);

	if(!$area){
		$link = SITE_LINK.'admin/manage_area.php';
		header("Location: {$link}");
	}

	if($_SERVER['REQUEST_METHOD'] === "POST" ){
        $name = $_POST['name'];
        $driver = isset($_POST['driver']) ? $_POST['driver'] : null;
        $driver = empty($driver) ? null : $driver;
        $area->name = $name;
        $area->driverId = $driver;
        $area->save();
        $session->flash('message', 'Area successfully updated');
        header("Location: manage_area.php");
    }

	$allDrivers = User::findAllByField('role','driver');
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
		<form action="<?php echo SITE_LINK . 'admin/edit_area.php?id=' . urlencode($area->id) ?>" method="post">
	    	<p>Name:
		        <input type="text" name="name" value="<?php echo htmlentities($area->name) ?>" required>
		    </p>
		    <?php
		    	if(!empty($allDrivers)){
		    ?>
		    <p>Assign To Driver:
		    	<select name="driver">
		    		<option value="0">Not Now</option>
		    		<?php
		    			foreach ($allDrivers as $key => $driver) {
		    				echo "<option value='" . $driver->id . "'";
		    				echo $driver->id === $area->driverId ? ' selected' : '';
		    				echo ">";
		    				echo htmlentities($driver->name) . "</option>";
		    			}
		    		?>
		    	</select>
		    </p>
		    <?php } ?>
		    <input type="submit" name="submit" value="Update Area">
	    </form>
	    <br><a href="manage_area.php">Cancel</a>
	</div>
</div>

<?php
	require_once LAYOUT_PATH.DS.'footer.php';
?>