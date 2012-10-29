<?php
	session_start();
	$current_dir = getcwd();
	chdir('../../backend');
	include('./a_dbconnector.php');
	chdir($current_dir);
	$myADBConnector = new advanced_dbconnector();
	$currentRights = $myADBConnector->getOneBenutzer($_SESSION['UID']);
	
	if($currentRights[4]['Xvalue'] != 1) {
		unset($myADBconnector);
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/index.php');
	}
	
	$Konfiguration = array();
	$Konfiguration['Kstyle'] = $_POST['Kstyle'];
	$Konfiguration['Ktitle'] = $_POST['Ktitle'];
	$Konfiguration['Knosnippet'] = $_POST['Knosnippet'];
	
	echo var_dump($Konfiguration);
	
	$myADBConnector->changeKonfiguration($Konfiguration);
	
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/konfiguration/index.php');
?>