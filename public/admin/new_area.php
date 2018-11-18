<?php
	require_once '../../includes/config.php';
	require_once LIB_PATH.DS.'Session.php';
	require_once LIB_PATH.DS.'Area.php';

	if(!$session->isLoggedIn() || !$session->isAdmin()){
		$link = SITE_LINK.'admin/login.php';
		header("Location: {$link}");
	}

	if($_SERVER['REQUEST_METHOD'] === "POST" ){
        $name = $_POST['name'];
        $driver = isset($_POST['driver']) ? $_POST['driver'] : null;
        $newArea = new Area;
        $newArea->name = $name;
        $newArea->driverId = $driver;
        var_dump($newArea);
        $newArea->save();
        $session->flash('message', 'Area successfully created');
        header("Location: manage_area.php");
    }

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
		<form action="new_area.php" method="post">
	    	<p>Name:
		        <input type="text" name="name" value="" required>
		    </p>
		    <input type="submit" name="submit" value="Create Area">
	    </form>
	    <br><a href="manage_area.php">Cancel</a>
	</div>
</div>

<?php
	require_once LAYOUT_PATH.DS.'footer.php';
?>