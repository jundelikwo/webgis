<?php
	require_once '../../includes/config.php';
	require_once LIB_PATH.DS.'Session.php';
	require_once LIB_PATH.DS.'Area.php';
	$link = SITE_LINK.'admin/login.php';
	if(!$session->isLoggedIn() || !$session->isAdmin()){
		header("Location: {$link}");
	}
	$id = isset($_GET['id']) ? $_GET['id'] : 0;
	$area = Area::findById($id);
	$link = SITE_LINK.'admin/manage_area.php';
	if(!empty($area)){
		$area->delete();
	}
	header("Location: {$link}");
?>