<?php
	session_start();
	session_regenerate_id(TRUE);
	$current_dir = getcwd();
	chdir('../../backend');
	include('./a_dbconnector.php');
	chdir($current_dir);
	$myADBConnector = new advanced_dbconnector();
	$currentRights = $myADBConnector->getOneBenutzer($_SESSION['UID']);
	
	if($currentRights[1]['Xvalue'] != 1) {
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
				<h2>Verwalten sie hier die Beitr&#228;ge</h2>
				<?php
					echo '<a href="Smask.php" id="important_green">Neuen Beitrag verfassen</a>';
				
					$alleBeitraege = $myADBConnector->getAllBeitraege();
					
					echo '<table><tr>';
					echo '<th>ID</th>';
					echo '<th>&#220;berschrift</th>';
					echo '<th>Kategorie</th>';
					echo '<th>Author</th>';
					echo '<th>Letzte &#196;nderung</th>';
					echo '<th>Ver&#246;ffentlicht</th>';
					echo '<th colspan="2">Beitrag &#228;ndern</th></tr>';
					for($i = 0; $i < count($alleBeitraege); $i++) {
						echo '<tr>';
						echo '<td>'.$alleBeitraege[$i]['SID'].'</td>';
						echo '<td>'.$alleBeitraege[$i]['Sheadline'].'</td>';
						echo '<td>'.$alleBeitraege[$i]['Cname'].'</td>';
						echo '<td>'.$alleBeitraege[$i]['Uname'].'</td>';
						echo '<td>'.$alleBeitraege[$i]['Slastmod'].'</td>';
						echo '<td>'.$alleBeitraege[$i]['Sreleased'].'</td>';
						echo '<td><a href="Smask.php?SID='.$alleBeitraege[$i]['SID'].'">bearbeiten</a></td>';
						echo '<td id="important_red"><a href="delete.php?SID='.$alleBeitraege[$i]['SID'].'">l&#246;schen</a></td>';
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