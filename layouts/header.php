<?php 
	/*if (!isset($layout_context)) {
		$layout_context = "public";
	}	
	if ($layout_context == "admin"){
		if(!isset($login_page)){
			confirm_logged_in();
		}
	}*/
?>
<!doctype html>

<html lang="en">
	<head>
		<title>Widget Corp <?php if($layout_context == "admin"){echo "Admin";} ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo SITE_LINK ?>css/public.css" media="all">
	</head>
	<body>
		<div id="header">
			<h1>Widget Corp <?php if($layout_context == "admin"){echo "Admin";} ?></h1>
		</div>