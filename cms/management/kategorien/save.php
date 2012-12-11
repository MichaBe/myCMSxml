<?php
	session_start();
	$current_dir = getcwd();
	chdir('../../backend');
	include('./a_dbconnector.php');
	chdir($current_dir);
	$myADBConnector = new advanced_dbconnector();
	$currentRights = $myADBConnector->getOneBenutzer($_SESSION['UID']);
	
	if($currentRights[2]['Xvalue'] != 1) {
		unset($myADBconnector);
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/index.php');
	}
	
	
	$newKategorie = array();
	$newKategorie['Cshorttext'] = $_POST['shorttext'];
	$newKategorie['Cname'] = $_POST['name'];
	$newKategorie['Ckeywords'] = $_POST['keywords'];
	
	if(isset($_POST['ID'])) {
		$myADBConnector->changeOneKategorie($_POST['ID'], $newKategorie);
	}
	else {
		$myADBConnector->addOneKategorie($newKategorie);
	}
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/kategorien/index.php');
?>