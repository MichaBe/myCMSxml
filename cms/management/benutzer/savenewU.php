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
	
	$testUname = $myADBConnector->getOneBenutzerByNameOrID($_POST['Uname']);
	if(isset($testUname[0]['UID']))
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/benutzer/Unewmask.php?error_name=TRUE');
	
	$newUID = $myADBConnector->addOneBenutzer($_POST['Uname'], md5(md5($_POST['Upassw'])));
			
	$currentUser = $myADBConnector->getOneBenutzerByNameOrID($_SESSION['UID']);
	$myADBConnector->addEreignis($currentUser[0]['Uname'].' erstellt Benutzer "'.$_POST['Uname'].'" (ID '.$newUID.')');
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/benutzer/index.php');
?>