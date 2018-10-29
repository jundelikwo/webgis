<?php
	require_once '../../includes/config.php';
	require_once LIB_PATH.DS.'Session.php';
	require_once LIB_PATH.DS.'User.php';

	if(!$session->isLoggedIn() || !$session->isAdmin()){
		$link = SITE_LINK.'admin/login.php';
		header("Location: {$link}");
	}
	$message = $session->getFlashValue('message');
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
			<h2>Manage Drivers</h2>
			<?php
				if($message){
					echo '<div class="message">' . $message . '</div>';
				}
				if(empty($allDrivers)){
					echo '<div class="message"><h3>There are no Drivers</h3></div>';
				}else{
				}
				echo '<a href="new_driver.php">Add a new driver</a>';
			?>
		</div>
	</div>
<?php
	require_once LAYOUT_PATH.DS.'footer.php';
?>