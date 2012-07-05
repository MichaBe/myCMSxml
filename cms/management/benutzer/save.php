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
	
		
	if(isset($_POST['UID'])) {
		$newBerechtigungen = array();
		$allRollen = $myADBConnector->getAllPossibleRights();
		$i = 0;
		foreach($allRollen  as $rolle) {
			$newBerechtigungen[$i]['Xvalue'] = $_POST[$rolle['RID']];
			$newBerechtigungen[$i]['RID'] = $rolle['RID'];
			$i++;
		}
		
		$myADBConnector->changeOneBenutzer($_POST['UID'], $_POST['Uname'], md5(md5($_POST['Upassw'])),$newBerechtigungen);
		
		$currentUser = $myADBConnector->getOneBenutzerByNameOrID($_SESSION['UID']);
		$myADBConnector->addEreignis('Benutzer '.$currentUser[0]['Uname'].' &#228;ndert Benutzer "'.$newBeitrag['Sheadline'].'" (ID '.$_POST['ID'].')');
	}
	else {
		$Berechtigungen = array();
		$allRollen = $myADBConnector->getAllPossibleRights();
		$i = 0;
		foreach($allRollen  as $rolle) {
			$Berechtigungen[$i]['Xvalue'] = $_POST[$rolle['RID']];
			$Berechtigungen[$i]['RID'] = $rolle['RID'];
			$i++;
		}
		$myADBConnector->addOneBenutzer()
		
		$currentUser = $myADBConnector->getOneBenutzerByNameOrID($_SESSION['UID']);
		$myADBConnector->addEreignis('Benutzer '.$currentUser[0]['Uname'].' erstellt Benutzer "'.$newBeitrag['Sheadline'].'"');
	
	}
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/beitraege/index.php');
?>