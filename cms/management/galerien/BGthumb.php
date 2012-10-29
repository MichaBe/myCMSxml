<?php
	session_start();
	$current_dir = getcwd();
	chdir('../../backend');
	include('./a_dbconnector.php');
	chdir($current_dir);
	$myADBConnector = new advanced_dbconnector();
	$currentRights = $myADBConnector->getOneBenutzer($_SESSION['UID']);
	
	if($currentRights[5]['Xvalue'] != 1) {
		unset($myADBconnector);
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/index.php');
	}
	
	if(isset($_GET['BGID']) && isset($_GET['BID'])) {
		
		$myADBConnector->setThumbfromBG($_GET['BGID'], $_GET['BID']);
		unset($myADBConnector);
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/galerien/BGmask.php?BGID='.$_GET['BGID']);
	}
	else {
		unset($myADBConnector);
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/galerien/index.php');
	}
?>