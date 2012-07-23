<?php
	$current_dir = getcwd();
	chdir('../backend');
	include('./a_dbconnector.php');
	chdir($current_dir);
	$myADBConnector = new advanced_dbconnector();
	
	$curUserHASH = md5(md5($_POST['passwSource']));
	$userToChange = $myADBConnector->getOneBenutzerByNameOrID($_POST['UID']);
	$newPasswHash1 = md5(md5($_POST['Upassw1']));
	$newPasswHash2 = md5(md5($_POST['Upassw2']));
	
	if($curUserHASH == $userToChange[0]['Upassw']) {
		if($newPasswHash1 == $newPasswHash2) {
			$myADBConnector->changeOneBenutzerPassw($_POST['UID'], $newPasswHash1, FALSE);
			session_start();
			$_SESSION['UID'] = $userToChange[0]['UID'];
			header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/index.php');
		}
		else 
			header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/Uchangepw.php?error_pw1u2=TRUE&UID='.$_POST['UID']);
	}
	else 
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/Uchangepw.php?error_pwOwn=TRUE&UID='.$_POST['UID']);	
?>