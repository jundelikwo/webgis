<?php
	require_once '../../includes/config.php';
	require_once LIB_PATH.DS.'Session.php';
	require_once LIB_PATH.DS.'Complain.php';
	if(!$session->isLoggedIn() || !$session->isAdmin()){
		$link = SITE_LINK.'admin/login.php';
		header("Location: {$link}");
	}
	$id = isset($_GET['id']) ? $_GET['id'] : 0;
	$complain = Complain::findById($id);
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
			<?php
				if(empty($complain)){
					echo '<div class="message">No Complain found</div>';
				}else{
					$complain->markAsViewed();
					echo '<h2>Complain</h2>';
					echo 'Name: '.htmlentities($complain->name).'<br>';
					echo 'Phone Number: '.htmlentities($complain->phone).'<br>';
					echo 'Date: '.htmlentities(strftime("%d-%b-%Y %I:%M %p", strtotime($complain->created))).'<br>';
					echo 'Complain: <div class="view-content">'.htmlentities($complain->complain).'</div>';
					echo '<a href="' . SITE_LINK.'admin/delete_complain.php?id=' . urlencode($complain->id) .'" onclick="' . "return confirm('Are you sure?');".'">Delete This Comment</a>';
				}
			?>
		</div>
	</div>
<?php
	require_once LAYOUT_PATH.DS.'footer.php';
?>