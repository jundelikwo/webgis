<?php
	require_once '../../includes/config.php';
	require_once LIB_PATH.DS.'Session.php';
	require_once LIB_PATH.DS.'user.php';
	$link = SITE_LINK.'admin/login.php';
	if(!$session->isLoggedIn() || !$session->isAdmin()){
		header("Location: {$link}");
	}
	$id = isset($_GET['id']) ? $_GET['id'] : 0;
	$driver = User::findById($id);
	$link = SITE_LINK.'admin/manage_driver.php';
	if(!empty($driver)){
		$driver->delete();
	}
	header("Location: {$link}");
?>