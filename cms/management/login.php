<?php
	include '/cms/backend/a_dbconnector.php';
	$myADBconnector = new advanced_dbconnector();
	$users = $myADBconnector->getOneBenutzer($_POST['username']);
	$currentUser;
	if(isset($users[0]['UID']))
		$currentUser = $myADBconnector->getOneBenutzer($users[0]['UID']);
	
	if(md5(md5($_POST['password'])) == $users[0]['Upassw'] && $currentUser[0]['Xvalue'] == 1) {
		session_start();
		$_SESSION['UID'] = $users[0]['UID'];
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/index.php');
	}
	else {
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/snippet.php?SID=1');
	}
?>