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
			<?php
				echo '<h1>Herzlich willkommen, '.$currentUser[0]['Uname'].'</h1>';
			?>
			<h2>Verwalten sie hier die Beitr&#228;ge</h2>
			<a href="../">zur&#252;ck zur Hauptseite</a>
			<?php
				$alleBeitraege = $myADBConnector->getAllBeitraege();
				
				echo '<table><tr>';
				echo '<th>&#220;berschrift</th>';
				echo '<th>Kategorie</th>';
				echo '<th>Author</th>';
				echo '<th>Letzte &#196;nderung</th>';
				echo '<th>Ver&#246;ffentlicht</th>';
				echo '<th colspan="2">Beitrag &#228;ndern</th></tr>';
				for($i = 0; $i < count($alleBeitraege); $i++) {
					echo '<tr>';
					echo '<td>'.$alleBeitraege[$i]['Sheadline'].'</td>';
					echo '<td>'.$alleBeitraege[$i]['Cname'].'</td>';
					echo '<td>'.$alleBeitraege[$i]['Uname'].'</td>';
					echo '<td>'.$alleBeitraege[$i]['Slastmod'].'</td>';
					echo '<td>'.$alleBeitraege[$i]['Sreleased'].'</td>';
					echo '<td><a href="Smask.php?SID='.$alleBeitraege[$i]['SID'].'">bearbeiten...</a></td>';
					echo '<td><a href="delete.php?SID='.$alleBeitraege[$i]['SID'].'">l&#246;schen...</a></td>';
					echo '</tr>';
				}
				
				echo '</table>';
				echo '<a href="Smask.php">Neuen Beitrag verfassen</a>';
			?>
		</div>
	</body>
	<?php
		unset($myADBConnector);
	?>
</html>