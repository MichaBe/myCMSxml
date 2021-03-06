<?php
	session_start();
	session_regenerate_id(TRUE);
	$current_dir = getcwd();
	chdir('../../backend');
	include('./a_dbconnector.php');
	chdir($current_dir);
	$myADBConnector = new advanced_dbconnector();
	$currentRights = $myADBConnector->getOneBenutzer($_SESSION['UID']);
	
	if($currentRights[4]['Xvalue'] != 1) {
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
			
			<?php include('../../backend/formanagement/getmenue.php'); ?>
			
			<div class="inhalt">
				<h2>Passen Sie hier die allgemeine Konfiguration an</h2>
				<?php
					echo '<a href="Kmask.php" id="important_green">Konfiguration &#228;ndern</a>';
					
					$Konfiguration = $myADBConnector->getKonfiguration();
					
					echo '<table><tr>';
					echo '<td>Blogtitel</td><td>'.$Konfiguration[1]['Kvalue'].'</td>';
					echo '</tr><tr>';
					echo '<td>Blogdesign</td><td>'.$Konfiguration[0]['Kvalue'].'</td>';
					echo '</tr><tr>';
					echo '<td>Text für leere Kategorien</td><td>'.$Konfiguration[2]['Kvalue'].'</td>';
					echo '</tr></table>';
				?>
			</div>
			<?php include('../../backend/formanagement/getfooter.php'); ?>
		</div>
	</body>
	<?php
		unset($myADBConnector);
	?>
</html>