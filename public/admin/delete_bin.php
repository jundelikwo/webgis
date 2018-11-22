<?php
	require_once '../../includes/config.php';
	require_once LIB_PATH.DS.'Session.php';
	require_once LIB_PATH.DS.'Bin.php';
	$link = SITE_LINK.'admin/login.php';
	if(!$session->isLoggedIn() || !$session->isAdmin()){
		header("Location: {$link}");
	}
	$id = isset($_GET['id']) ? $_GET['id'] : 0;
	$bin = Bin::findById($id);
	$link = SITE_LINK.'admin/manage_bin.php';
	if(!empty($bin)){
		$bin->delete();
	}
	header("Location: {$link}");
?>