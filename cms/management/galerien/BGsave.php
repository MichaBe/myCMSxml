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
	
	
	$newBG = array();
	$newBG['CID'] = $_POST['CID'];
	$newBG['BGname'] = $_POST['name'];
	if(isset($_POST['ID'])) {
		$myADBConnector->changeOneBildgruppe($_POST['ID'], $newBG);
	}
	else {
		$myADBConnector->addOneBildgruppe($newBG);
	}
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/galerien/index.php');
?>