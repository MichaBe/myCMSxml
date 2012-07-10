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
		
		$currentUser = $myADBConnector->getOneBenutzerByNameOrID($_SESSION['UID']);
		$myADBConnector->addEreignis($currentUser[0]['Uname'].' &#228;ndert Benutzer "'.$newBeitrag['Sheadline'].'" (ID '.$_POST['ID'].')');
	}
	else {
		$testUname = $myADBConnector->getOneBenutzerByNameOrID($_POST['Uname']);
		if(isset($testUname[0]['UID']))
			header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/benutzer/Umask.php?error_name=TRUE');
		
		
		else {
			$allRights = $myADBConnector->getAllPossibleRights();
			$newRights = array();
			$i = 0;
			foreach ($allRights as $Rolle) {
				$newRights[$i]['RID'] = $Rolle['RID'];
				$newRights[$i]['Xvalue'] = $_POST[$Rolle['RID']];
				$i++;
			}
			$myADBConnector->addOneBenutzer($_POST['Uname'], md5(md5($_POST['Upassw'])), $newRights);
			$currentUser = $myADBConnector->getOneBenutzerByNameOrID($_SESSION['UID']);
			$myADBConnector->addEreignis($currentUser[0]['Uname'].' erstellt Benutzer "'.$_POST['Uname'].'"');
		}
	}
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/benutzer/index.php');
?>