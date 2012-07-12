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
		
	if(isset($_GET['UID'])) {
		$curUser = $myADBConnector->getOneBenutzerByNameOrID($_GET['UID']);
		
		if(isset($curUser[0]['UID'])) {
			$allBeitraege = $myADBConnector->getAllBeitraege();
			foreach ($allBeitraege as $curBeitrag) {
				if($curBeitrag['Uname'] == $curUser[0]['Uname']) {
					$beitrag = $myADBConnector->getOneBeitrag($curBeitrag['SID']);
					$beitrag[0]['UID'] = 2;
					$beitrag[0]['Sreleased'] = FALSE;
					$myADBConnector->changeOneBeitrag($beitrag[0]['SID'], $beitrag[0]);
					$myADBConnector->addEreignis('Anonymous &#228;ndert Beitrag "'.$beitrag[0]['Sheadline'].'" (ID '.$beitrag[0]['SID'].')');
				}
			}
			$myADBConnector->delOneBenutzer($curUser[0]['UID']);
			
			$currentUser = $myADBConnector->getOneBenutzerByNameOrID($_SESSION['UID']);
			$myADBConnector->addEreignis($currentUser[0]['Uname'].' l&#246;scht Benutzer "'.$curUser[0]['Uname'].'" (ID '.$_GET['UID'].')');
		}
	}
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/benutzer/index.php');
?>