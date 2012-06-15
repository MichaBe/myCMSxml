<?php
	session_start();
	$current_dir = getcwd();
	chdir('../../backend');
	include('./a_dbconnector.php');
	chdir($current_dir);
	$myADBConnector = new advanced_dbconnector();
	$currentRights = $myADBConnector->getOneBenutzer($_SESSION['UID']);
	
	if($currentRights[1]['Xvalue'] != 1) {
		unset($myADBconnector);
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/index.php');
	}
	
	
	$newBeitrag = array();
	$newBeitrag['CID'] = $_POST['cid'];
	$newBeitrag['Sheadline'] = $_POST['headline'];
	$newBeitrag['Sshorttext'] = $_POST['shorttext'];
	$newBeitrag['Stext'] = $_POST['text'];
	if(isset($_POST['released']))
		$newBeitrag['Sreleased'] = TRUE;
	$newBeitrag['Skeywords'] = $_POST['keywords'];
	
	var_dump($newBeitrag);
	
	if(isset($_POST['ID'])) {
		$myADBConnector->changeOneBeitrag($_POST['ID'], $newBeitrag);
		
		$currentUser = $myADBConnector->getOneBenutzerByNameOrID($_SESSION['UID']);
		$myADBConnector->addEreignis('Benutzer '.$currentUser[0]['Uname'].' &#228;ndert Beitrag "'.$newBeitrag['Sheadline'].'" (ID '.$_POST['ID'].')');
	}
	else {
		$newBeitrag['UID'] = $_SESSION['UID'];
		$myADBConnector->addOneBeitrag($newBeitrag);
		
		$currentUser = $myADBConnector->getOneBenutzerByNameOrID($_SESSION['UID']);
		$myADBConnector->addEreignis('Benutzer '.$currentUser[0]['Uname'].' erstellt Beitrag "'.$newBeitrag['Sheadline'].'"');
	
	}
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/beitraege/index.php');
?>