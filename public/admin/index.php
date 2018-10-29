<?php
	require_once '../../includes/config.php';
	require_once LIB_PATH.DS.'Session.php';
	if(!$session->isLoggedIn()){
		$link = SITE_LINK.'admin/login.php';
		header("Location: {$link}");
	}
	$layout_context = $session->isAdmin() ? 'admin' : '';
	require_once LAYOUT_PATH.DS.'header.php';
?>

	<div id="main">
		<div id="navigation">
			<ul class="subjects">
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