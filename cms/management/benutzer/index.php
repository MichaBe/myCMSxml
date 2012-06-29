<?php
	session_start();
	session_regenerate_id(TRUE);
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
	
	$currentUser = $myADBConnector->getOneBenutzerByNameOrID($_SESSION['UID']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>myCMSxml</title>
		<link rel="stylesheet" type="text/css" href="../cms.css" />
	</head>
	<body>
		<div class="wrapper">
			<div class="navigation">
				<ul>
					<?php
						echo '<li><a href="../">Zur Startseite</a></li>';
						for($i = 1; $i < count($currentRights); $i++) {
							if($currentRights[$i]['Xvalue'] == 1)
								echo '<li><a href="../'.$currentRights[$i]['Rshort'].'/">'.$currentRights[$i]['Rtopic'].'</a></li>';
						}						
						echo '<li><a href="../logout.php">Vom System abmelden</a></li>';
					?>
				</ul>
			</div>
			<div class="inhalt">
				<h2>Verwalten Sie hier die Benutzer und ihre Berechtigungen</h2>
				<?php
					echo '<a href="Umask.php" id="important_green">Neuen Benutzer erstellen</a>';
				
					$alleBenutzer = $myADBConnector->getAllBenutzer();
					$alleRollen = $myADBConnector->getAllPossibleRights();
					
					echo '<table><tr>';
					echo '<th>Benutzername</th>';
					foreach($alleRollen as $currentRolle) {
						echo '<th>'.$currentRolle['Rshort'].'</th>';
					}
					echo '<th colspan="2">Benutzer &#228;ndern</th></tr>';
					foreach($alleBenutzer as $currBenutzer) {
						$BenutzerRights = $myADBConnector->getOneBenutzer($currBenutzer['UID']);
						echo '<tr><td>'.$currBenutzer['Uname'].'</td>';
						foreach($alleRollen as $currentRolle) {
							if($BenutzerRights[0]['Xvalue'] == 1)
								echo '<td id="important_green">berechtigt</td>';
							else
								echo '<td id="important_red">nicht berechtigt</td>';
						}
						if($currBenutzer['UID'] > 2) {
							echo '<td id="important_green"><a href="Umask.php?UID='.$currBenutzer['UID'].'">bearbeiten</a></td>';
							echo '<td id="important_red"><a href="delete.php?UID='.$currBenutzer['UID'].'">l&#246;schen</a></td>';
						}
						else {
							echo '<td>bearbeiten</td>';
							echo '<td>l&#246;schen</td></tr>';
						}
					}					
					echo '</table>';
				?>
			</div>
			<?php include('../../backend/formanagement/getfooter.php'); ?>
		</div>
	</body>
	<?php
		unset($myADBConnector);
	?>
</html>