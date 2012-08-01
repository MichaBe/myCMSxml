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
		$curGalerie = $myADBConnector->getOneGalerie($_GET['CID']);
		echo var_dump($curGalerie);
		if(isset($curGalerie[0]['CID'])) {
			if(!($curGalerie[0]['CID'] <= 4) && $curGalerie[0]['Ctarget'] == 'galerie') {
				$myADBConnector->delOneGalerie($curGalerie[0]['CID']);
				
				$currentUser = $myADBConnector->getOneBenutzerByNameOrID($_SESSION['UID']);
				$myADBConnector->addEreignis($currentUser[0]['Uname'].' l&#246;scht Galerie "'.$curGalerie[0]['Cname'].'" (ID '.$_GET['CID'].')');
			}
		}
	}
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/galerien/index.php');
?>