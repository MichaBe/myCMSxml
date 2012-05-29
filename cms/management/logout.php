<?php
	session_start();
	$_SESSION = array();
	session_destroy();
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/snippet.php?SID=1');
?>
