<?php
	require_once '../../includes/config.php';
	require_once LIB_PATH.DS.'Session.php';
	require_once LIB_PATH.DS.'User.php';

	if(!$session->isLoggedIn() || !$session->isAdmin()){
		$link = SITE_LINK.'admin/login.php';
		header("Location: {$link}");
	}

	if($_SERVER['REQUEST_METHOD'] === "POST" ){
        $username = $_POST['username'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        $newDriver = new User;
        $newDriver->name = $name;
        $newDriver->username = $username;
        $newDriver->updatePassword($password);
        $newDriver->save();
        $session->flash('message', 'Driver successfully created');
        header("Location: manage_driver.php");
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
		<form action="new_driver.php" method="post">
	    	<p>Name:
		        <input type="text" name="name" value="" required>
		    </p>
	    	<p>Username:
		        <input type="text" name="username" value="" required>
		    </p>
		    <p>Password:
		    	<input type="password" name="password" value="" required>
		    </p>
		    <input type="submit" name="submit" value="Create Driver">
	    </form>
	    <br><a href="manage_driver.php">Cancel</a>
	</div>
</div>

<?php
	require_once LAYOUT_PATH.DS.'footer.php';
?>