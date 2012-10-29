<?php
	session_start();
	$current_dir = getcwd();
	chdir('../../backend');
	include('./a_dbconnector.php');
	chdir($current_dir);
	$myADBConnector = new advanced_dbconnector();
	$currentRights = $myADBConnector->getOneBenutzer($_SESSION['UID']);
	
	if($currentRights[3]['Xvalue'] != 1) {
		unset($myADBconnector);
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/index.php');
	}
	
	$curUserHASH = md5(md5($_POST['passwSource']));
	$curUser = $myADBConnector->getOneBenutzerByNameOrID($_SESSION['UID']);
	$userToChange = $myADBConnector->getOneBenutzerByNameOrID($_POST['UID']);
	$newPasswHash1 = md5(md5($_POST['Upassw1']));
	$newPasswHash2 = md5(md5($_POST['Upassw2']));
	
	if($curUserHASH == $curUser[0]['Upassw']) {
		if($newPasswHash1 == $newPasswHash2) {
			$myADBConnector->changeOneBenutzerPassw($_POST['UID'], $newPasswHash1, TRUE);
			header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/benutzer/index.php');
		}
		else 
			header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/benutzer/PWmask.php?error_pw1u2=TRUE&UID='.$_POST['UID']);
	}
	else 
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/benutzer/PWmask.php?error_pwOwn=TRUE&UID='.$_POST['UID']);	
?>