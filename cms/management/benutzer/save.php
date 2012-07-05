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
	
		
	if(isset($_POST['UID'])) {
		$newBerechtigungen = array();
		
		$myADBConnector->changeOneBeitrag($_POST['ID'], $newBeitrag);
		
		$currentUser = $myADBConnector->getOneBenutzerByNameOrID($_SESSION['UID']);
		$myADBConnector->addEreignis('Benutzer '.$currentUser[0]['Uname'].' &#228;ndert Benutzer "'.$newBeitrag['Sheadline'].'" (ID '.$_POST['ID'].')');
	}
	else {
		$newBeitrag['UID'] = $_SESSION['UID'];
		$myADBConnector->addOneBeitrag($newBeitrag);
		
		$currentUser = $myADBConnector->getOneBenutzerByNameOrID($_SESSION['UID']);
		$myADBConnector->addEreignis('Benutzer '.$currentUser[0]['Uname'].' erstellt Benutzer "'.$newBeitrag['Sheadline'].'"');
	
	}
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/beitraege/index.php');
?>