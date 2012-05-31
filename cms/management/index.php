<?php
	session_start();
	session_regenerate_id(TRUE);
	$current_dir = getcwd();
	chdir('../backend');
	include('./a_dbconnector.php');
	chdir($current_dir);
	$myADBConnector = new advanced_dbconnector();
	$currentRights = $myADBConnector->getOneBenutzer($_SESSION['UID']);
	
	if($currentRights[0]['Xvalue'] != 1) {
		unset($myADBconnector);
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/logout.php');
	}
	
	$currentUser = $myADBConnector->getOneBenutzerByNameOrID($_SESSION['UID']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>myCMSxml</title>
		<link rel="stylesheet" type="text/css" href="/cms/management/cms.css" />
	</head>
	<body>
		<div class="wrapper">
			<?php
				echo '<h1>Herzlich willkommen, '.$currentUser[0]['Uname'].'</h1>';
			?>
			<h2>Was m&#246;chten Sie tun?</h2>
			<ul>
				<?php
					if($currentRights[1]['Xvalue'] == 1)
						echo '<li><a href="beitraege/">Beitr&#228;ge verwalten</a></li>';
					if($currentRights[2]['Xvalue'] == 1)
						echo '<li><a href="#">Kategorien verwalten</a></li>';
					if($currentRights[3]['Xvalue'] == 1)
						echo '<li><a href="#">Benutzer und Berechtigungen verwalten</a></li>';
					if($currentRights[4]['Xvalue'] == 1)
						echo '<li><a href="#">Allgemeine Konfiguration &#228;ndern</a></li>';
					if($currentRights[5]['Xvalue'] == 1)
						echo '<li><a href="#">Ereignislog einsehen</a></li>';
					if($currentRights[6]['Xvalue'] == 1)
						echo '<li><a href="#">Hilfe aufrufen</a></li>';
					
					echo '<li><a href="logout.php">Vom System abmelden</a></li>';
				?>
			</ul>
		</div>
	</body>
	<?php
		unset($myADBConnector);
	?>
</html>