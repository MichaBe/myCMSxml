<?php
	$user_xml = simplexml_load_file("../users.xml");
	$username = $_POST['username'];
	$passhash = md5(md5($_POST['passwort']));
	$valid_user = FALSE;
	$user_ID;
	for ($i = 0; $i < count($user_xml->user); $i++) {
		if($user_xml->user[$i]->name == $username && $user_xml->user[$i]->passw == $passhash) {
			$valid_user = TRUE;
			$user_ID =  md5(md5($user_xml->user[$i]->id)); //TODO: Fehler: Hier liegt noch ein SimpleXML-Objekt vor. Muss davor noch in eine 'reine' Vairable geformt werden
			break;
		}
	}
	
	if($valid_user) {
		session_start();
		$_SESSION['UID'] = $user_ID;
		$_SESSION['seed'] = rand(1000, 9999);
		$_SESSION['v_md5'] = md5(md5($_SESSION['seed']));
		$hostname = $_SERVER['HTTP_HOST'];
		header('Location: http://' . $hostname . '/cms/management/overview.php');
	}
	else {
		$hostname = $_SERVER['HTTP_HOST'];
		header('Location: http://' . $hostname  . '/error.php');
	}
?>