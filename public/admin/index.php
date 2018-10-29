<?php
	require_once '../../includes/config.php';
	require_once LIB_PATH.DS.'Session.php';
	if(!$session->isLoggedIn()){
		$link = SITE_LINK.'admin/login.php';
		header("Location: {$link}");
	}
	$layout_context = 'admin';
	require_once LAYOUT_PATH.DS.'header.php';
?>

	<div id="main">
		<div id="navigation">
			<ul class="subjects">
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
			<h2>Admin Menu</h2>
			<p>Welcome to the admin area, jonathan.</p>
			
			<ul>
				<li><a href="manage_content.php">Manage Drivers</a></li>
				<li><a href="manage_admins.php">Manage Complains</a></li>
				<li><a href="manage_admins.php">Manage Bins</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</div>
	</div>
<?php
	require_once LAYOUT_PATH.DS.'footer.php';
?>