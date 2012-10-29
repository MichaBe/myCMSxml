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
	
	if(isset($_GET['UID']) && isset($_GET['RID']) && isset($_GET['Xvalue'])) {
		$myADBConnector->changeOneBenutzer($_GET['UID'], $_GET['RID'], $_GET['Xvalue']);
	}
	
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/benutzer/index.php');
	
?>