<?php
	$current_dir = getcwd();
	chdir('../backend/');
	include(getcwd().'/a_dbconnector.php');
	chdir($current_dir);
	$myADBconnector = new advanced_dbconnector();
	$users = $myADBconnector->getOneBenutzerByName($_POST['username']);
	$currentUser;
	if(isset($users[0]['UID']))
		$currentUser = $myADBconnector->getOneBenutzer($users[0]['UID']);
	
	if(md5(md5($_POST['passwort'])) == $users[0]['Upassw'] && $currentUser[0]['Xvalue'] == 1) {
		session_start();
		$_SESSION['UID'] = $users[0]['UID'];
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/index.php');
	}
	/*else {
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/snippet.php?SID=1');
	}*/
	echo "Anmeldung fehlgeschlagen";
	var_dump($users);
?>