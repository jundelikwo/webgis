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
		<title>Sylvia WebGIS <?php echo $layout_context ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo SITE_LINK ?>css/public.css" media="all">
	</head>
	<body>
		<div id="header">
			<h1><a style="color:white;text-decoration:none" href="<?php echo SITE_LINK ?>">Sylvia WebGIS <?php echo $layout_context; ?></a></h1>
		</div>