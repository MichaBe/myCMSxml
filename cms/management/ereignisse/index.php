<?php
	session_start();
	session_regenerate_id(TRUE);
	$current_dir = getcwd();
	chdir('../../backend');
	include('./a_dbconnector.php');
	chdir($current_dir);
	$myADBConnector = new advanced_dbconnector();
	$currentRights = $myADBConnector->getOneBenutzer($_SESSION['UID']);
	
	if($currentRights[5]['Xvalue'] != 1) {
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
				<h2>Sehen Sie hier den Ereignislog ein</h2>
				<?php
					$allEreignisse = $myADBConnector->getAllEreignisse();
					
					echo '<a href="delete.php" id="important_red">Log leeren</a>';
					echo '<table><tr>';
					echo '<td colspan="3"><form action="save.php" method="POST">';
					echo '<input type="text" size="50" maxlength="50" name="Etext"/><input type="submit" value="Ereignis loggen" /></form></td>';
					echo '</tr><tr>';
					echo '<th>Datum</th><th>Ereignistext</th>';
					echo '<th>';
					echo '<form action="index.php" method="POST"><input type="text" name="search" size="20" maxlength="20" /><input type="submit" value="suchen" /></form>';
					echo '</th></tr>';
					
					if(isset($_POST['search'])) {
						if($_POST['search'] != "")
							$allEreignisse = $myADBConnector->searchEreignis($_POST['search']);
					}
					
					foreach($allEreignisse as $curEreignis) {
						echo '<tr>';
						echo '<td>'.$curEreignis['Etime'].'</td>';
						echo '<td colspan="2">'.$curEreignis['Etext'].'</td>';
						echo '</tr>';
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