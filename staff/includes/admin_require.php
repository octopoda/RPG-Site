<?php
	require_once($_SERVER['DOCUMENT_ROOT']. "/lib/web_config.php");
	require_once($_SERVER['DOCUMENT_ROOT']. "/includes/require.php");

	if (isset($_SESSION['user_id'])) {
		$users = new Users($_SESSION['user_id']);
	} else {
		$users = new Users();
	}
?>