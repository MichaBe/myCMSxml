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
		
	if(isset($_GET['CID'])) {
		$curKategorie = $myADBConnector->getOneKategorie($_GET['CID']);
		if(isset($curKategorie[0]['CID'])) {
			if(!($curKategorie[0]['CID'] <= 4)) {
				$myADBConnector->movetoHIDDENfromOneKategorie($curKategorie[0]['CID']);
				$myADBConnector->delOneKategorie($curKategorie[0]['CID']);
			}
		}
	}
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/kategorien/index.php');
?>