<?php
	session_start();
	session_destroy();
	
	$hostname = $_SERVER['HTTP_HOST'];

     header('Location: http://'.$hostname.'/snippet.php?SID=S9999');
?>