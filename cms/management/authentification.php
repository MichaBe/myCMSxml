<?php
function auth($pathToUsersXML) {
	session_start();
	$user_xml = simplexml_load_file($pathToUsersXML);
	$valid_UID = FALSE;
	$valid_seed = FALSE;

	for ($i = 0; $i < count($user_xml -> user); $i++) {
		if (md5(md5($user_xml -> user[$i] -> id)) == $_SESSION['UID'])
			$valid_UID = TRUE;
	}
	if ($_SESSION['v_md5'] == md5(md5($_SESSION['seed']))) {
		$valid_seed = TRUE;
	}

	if (!($valid_UID && $valid_seed)) {
		session_destroy();
		unset($_SESSION);
		$hostname = $_SERVER['HTTP_HOST'];
		header('Location: http://' . $hostname . '/snippet.php?SID=S9999');
	}
}
?>