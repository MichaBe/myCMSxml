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
		
	if(isset($_GET['SID'])) {
		$curBeitrag = $myADBConnector->getOneBeitrag($_GET['SID']);
		if(isset($curBeitrag[0]['SID'])) {
			if($curBeitrag[0]['CID'] == 3) {
				$myADBConnector->delOneBeitrag($curBeitrag[0]['SID']);
			}
			else {
				$curBeitrag[0]['CID'] = 3;
				$myADBConnector->changeOneBeitrag($curBeitrag[0]['SID'], $curBeitrag[0]);
			}
		}
	}
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/beitraege/index.php');
?>