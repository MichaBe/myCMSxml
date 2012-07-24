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
		<link rel="stylesheet" type="text/css" href="cms.css" />
	</head>
	<body>
		<div class="wrapper">
			<div class="navigation">
				<ul>
					<?php
						echo '<li><a href="#">Zur Startseite</a></li>';
						for($i = 1; $i < count($currentRights); $i++) {
							if($currentRights[$i]['Xvalue'] == 1)
								echo '<li><a href="'.$currentRights[$i]['Rshort'].'/">'.$currentRights[$i]['Rtopic'].'</a></li>';
						}						
						echo '<li><a href="logout.php">Vom System abmelden</a></li>';
					?>
				</ul>
			</div>
			<div class="inhalt">
				<?php
					$curdate = date("Y-m-d", time());
					$curdate = new DateTime($curdate);
					$installationdate = $myADBConnector->getallEreignisse();
					$installationdate = new DateTime($installationdate[0]['Etime']);
					$diff = $installationdate->diff($curdate);
					
					$CMStipps = $myADBConnector->getallMOTD("CMS");
					$STYLEtipps = $myADBConnector->getallMOTD("STYLE");
					
					$curCMStipp = $CMStipps[($diff->d)%(count($CMStipps))];
					$curSTYtipp = $CMStipps[($diff->d)%(count($STYLEtipps))];
					echo '<h1>Herzlich willkommen, '.$currentUser[0]['Uname'].'</h1>';
					echo '<div id="important_green">';
					echo 'Message of the day - CMS: '.$curCMStipp['Mmessage'];
					echo '</div>';
					echo '<div id="important_green">';
					echo 'Message of the day - Style: '.$curSTYtipp['Mmessage'];
					echo '</div>';
				?>
			</div>
			<?php include('../backend/formanagement/getfooter.php'); ?>
		</div>
	</body>
	<?php
		unset($myADBConnector);
	?>
</html>