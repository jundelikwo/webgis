<?php
	require_once '../../includes/config.php';
	$layout_context = 'admin';
	require_once LAYOUT_PATH.DS.'header.php';
?>

	<div id="main">
	<div id="navigation">
			<ul class="subjects">
				<li><a href="index.php?subject=1">Manage Drivers</a></li>
				<li><a href="index.php?subject=2">Manage Complains</a></li>
				<li><a href="index.php?subject=3">Manage Bins</a></li>
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