<?php
	session_start();
	$current_dir = getcwd();
	chdir('../../backend');
	include('./a_dbconnector.php');
	chdir($current_dir);
	$myADBConnector = new advanced_dbconnector();
	$currentRights = $myADBConnector->getOneBenutzer($_SESSION['UID']);
	
	if($currentRights[6]['Xvalue'] != 1) {
		unset($myADBconnector);
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/index.php');
	}
	
	
	$newKategorie = array();
	$newKategorie['Cshorttext'] = $_POST['shorttext'];
	$newKategorie['Cname'] = $_POST['name'];
	$newKategorie['Ckeywords'] = $_POST['keywords'];
	$newKategorie['Ctarget'] = 'galerie';
	
	if(isset($_POST['ID'])) {
		$myADBConnector->changeOneKategorie($_POST['ID'], $newKategorie);
		
		$currentUser = $myADBConnector->getOneBenutzerByNameOrID($_SESSION['UID']);
		$myADBConnector->addEreignis($currentUser[0]['Uname'].' &#228;ndert Galerie "'.$newKategorie['Cname'].'" (ID '.$_POST['ID'].')');
	}
	else {
		$myADBConnector->addOneKategorie($newKategorie);
		
		$currentUser = $myADBConnector->getOneBenutzerByNameOrID($_SESSION['UID']);
		$myADBConnector->addEreignis($currentUser[0]['Uname'].' erstellt Galerie "'.$newKategorie['Cname'].'"');
	
	}
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/galerien/index.php');
?>