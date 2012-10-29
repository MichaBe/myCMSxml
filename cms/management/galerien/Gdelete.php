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
		
	if(isset($_GET['CID'])) {
		$curGalerie = $myADBConnector->getOneGalerie($_GET['CID']);
		echo var_dump($curGalerie);
		if(isset($curGalerie[0]['CID'])) {
			if(!($curGalerie[0]['CID'] <= 4) && $curGalerie[0]['Ctarget'] == 'galerie') {
				$myADBConnector->delOneGalerie($curGalerie[0]['CID']);
			}
		}
	}
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/galerien/index.php');
?>