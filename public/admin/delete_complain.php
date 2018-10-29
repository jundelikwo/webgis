<?php
	require_once '../../includes/config.php';
	require_once LIB_PATH.DS.'Session.php';
	require_once LIB_PATH.DS.'Complain.php';
	$link = SITE_LINK.'admin/login.php';
	if(!$session->isLoggedIn() || !$session->isAdmin()){
		header("Location: {$link}");
	}
	$id = isset($_GET['id']) ? $_GET['id'] : 0;
	$complain = Complain::findById($id);
	$link = SITE_LINK.'admin/manage_complain.php';
	if(!empty($complain)){
		$complain->delete();
	}
	header("Location: {$link}");
?>