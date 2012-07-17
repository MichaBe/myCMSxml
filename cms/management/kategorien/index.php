<?php
	session_start();
	session_regenerate_id(TRUE);
	$current_dir = getcwd();
	chdir('../../backend');
	include('./a_dbconnector.php');
	chdir($current_dir);
	$myADBConnector = new advanced_dbconnector();
	$currentRights = $myADBConnector->getOneBenutzer($_SESSION['UID']);
	
	if($currentRights[2]['Xvalue'] != 1) {
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
				<h2>Verwalten Sie hier die Kategorien</h2>
				<?php
					echo '<a href="Cmask.php" id="important_green">Neue Kategorie erstellen</a>';
				
					$alleKategorien = $myADBConnector->getAllKategorien();
					
					echo '<table><tr>';
					echo '<th>ID</th>';
					echo '<th>Name</th>';
					echo '<th>Schl&#252;sselw&#246;rter</th>';
					echo '<th>Beitr&#228;ge</th>';
					echo '<th colspan="2">Kategorie &#228;ndern</th></tr>';
					for($i = 0; $i < count($alleKategorien); $i++) {
						echo '<tr>';
						echo '<td>'.$alleKategorien[$i]['CID'].'</td>';
						echo '<td>'.$alleKategorien[$i]['Cname'].'</td>';
						echo '<td>'.$alleKategorien[$i]['Ckeywords'].'</td>';
						echo '<td>'.$alleKategorien[$i]['Scount'].'</td>';
						echo '<td id="important_green"><a href="Cmask.php?CID='.$alleKategorien[$i]['CID'].'">bearbeiten</a></td>';
						if($alleKategorien[$i]['CID'] <= 4)
							echo '<td>l&#246;schen</td>';
						else
							echo '<td id="important_red"><a href="delete.php?CID='.$alleKategorien[$i]['CID'].'">l&#246;schen</a></td>';
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