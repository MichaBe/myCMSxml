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
	
	if(isset($_GET['BGID']) && isset($_GET['BID'])) {
		if(file_exists('../../bilder/B'.$_GET['BID'].'.jpg'))
			unlink('../../bilder/B'.$_GET['BID'].'.jpg');
		if(file_exists('../../bilder/B'.$_GET['BID'].'thmb.jpg'))
			unlink('../../bilder/B'.$_GET['BID'].'thmb.jpg');
		
		$curBildgruppe = $myADBConnector->getOneBildgruppe($_GET['BGID']);
		if($curBildgruppe[0]['BGthumb'] == $_GET['BID']){
			$myADBConnector->setThumbfromBG($_GET['BGID']);
		}
		$myADBConnector->delOneBild($_GET['BID']);
		
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/galerien/BGmask.php?BGID='.$_GET['BGID']);
	}
	else {
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/galerien/');
	}
	unset($myADBConnector);
	
	
?>