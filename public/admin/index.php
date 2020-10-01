<?php
	require_once '../../includes/config.php';
	require_once LIB_PATH.DS.'Session.php';
	require_once LIB_PATH.DS.'User.php';
	if(!$session->isLoggedIn()){
		$link = SITE_LINK.'admin/login.php';
		header("Location: {$link}");
	}
	$driver = User::findById($session->getId());
	$layout_context = $session->isAdmin() ? 'Admin' : 'Driver';
	require_once LAYOUT_PATH.DS.'header.php';
?>

	<div id="main">
		<div id="navigation">
			<ul class="subjects">
				<?php echo '<li><h2>Hello ' . $driver->name . '</h2></li>'; ?>
				<li><a href="<?php echo SITE_LINK ?>">Home</a></li>
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
				<?php
					if($session->isAdmin()){
						require_once LAYOUT_PATH.DS.'admin_home.php';
					}else{
						require_once LAYOUT_PATH.DS.'driver_home.php';
					}
				?>
		</div>
	</div>
<?php
	require_once LAYOUT_PATH.DS.'footer.php';
?>