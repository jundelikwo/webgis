<?php
	require_once("../../includes/config.php");
	require_once(LIB_PATH.DS."Session.php");
	
    $session->logout();
    $link = SITE_LINK;
    header("Location: {$link}");
?>