<?php
	function authentificate($Rolle) {
		
		$currentUser = $myADBconnector->getOneBenutzer($_SESSION['UID']);
		if($currentUser[$Rolle-1]['Xvalue'] == 1)
			return TRUE;
		else {
			unset($myADBconnector);
			header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/logout.php');
		}
	}
?>