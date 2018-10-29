<?php
	require_once '../../includes/config.php';
	require_once LIB_PATH.DS.'Session.php';
	require_once LIB_PATH.DS.'Complain.php';
	if(!$session->isLoggedIn() || !$session->isAdmin()){
		$link = SITE_LINK.'admin/login.php';
		header("Location: {$link}");
	}
	$message = $session->getFlashValue('message');
	$allComplains = Complain::findAll();
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
			<h2>Manage Complains</h2>
			<?php
				if($message){
					echo '<div class="message">' . $message . '</div>';
				}
				if(empty($allComplains)){
					echo '<div class="message"><h3>There are no Complains</h3></div>';
				}else{
			?>
			<table>
		    	<tbody>
			      	<tr>
				        <th style="text-align: left">User</th>
				        <th style="text-align: left">&nbsp;Complain</th>
				        <th style="text-align: left">&nbsp;Date</th>
				        <th colspan="2" style="text-align: left;">&nbsp;Actions</th>

				    </tr>
				    <?php
				    	foreach ($allComplains as $key => $complain) {
				    ?>
			        <tr>
				        <td><?php echo substr(htmlentities($complain->name),0,10) ?></td>
				        <td>&nbsp;<?php echo substr(htmlentities($complain->complain),0,20) ?>...</td>
				        <td>&nbsp;<?php echo htmlentities(strftime("%d-%b-%Y %I:%M %p", strtotime($complain->created)))?></td>
				        <td>&nbsp;<a href="view_complain.php?id=<?php echo urlencode($complain->id)?>">View</a></td>
				        <td>&nbsp;<a href="delete_complain.php?id=<?php echo urlencode($complain->id)?>" onclick="return confirm('Are you sure?');">Delete</a></td>
			      	</tr>
			    	<?php } } ?>
		        </tbody>
		    </table>
		</div>
	</div>
<?php
	require_once LAYOUT_PATH.DS.'footer.php';
?>