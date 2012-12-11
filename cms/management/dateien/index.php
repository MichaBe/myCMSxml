<?php
	session_start();
	session_regenerate_id(TRUE);
	$current_dir = getcwd();
	chdir('../../backend');
	include('./a_dbconnector.php');
	include('./a_filemanager.php');
	chdir($current_dir);
	$myADBConnector = new advanced_dbconnector();
	$myFileManager = new advanced_filemanager();
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
			
			<?php include('../../backend/formanagement/getmenue.php'); ?>
			
			<div class="inhalt">
				<h2>Verwalten Sie hier die Dateien</h2>
				<?php
					$allProperties = $myFileManager->geAllsProperties();
					echo '<table><tr>';
					echo '<th>Titel</th>';
					echo '<th>Typ</th>';
					echo '<th>Verwendet<th>';
					echo '<th>Link</th>';
					echo '<th colspan="2">Datei &#288;ndern</th></tr>';
					
					for($i = 0; $i < count($allProperties); $i++) {
						echo '<tr>';
						echo '<td>'.$allProperties[$i]['Fname'].'</td>';
						echo '<td>'.$allProperties[$i]['Ftype'].'</td>';
						echo '<td>'.$allProperties[$i]['Fcount'].'</td>';
						echo '<td><a href="http://'.$_SERVER['HTTP_HOST'].'/cms/'..'"'
						echo '</tr>';
					}
				?>
			</div>
			<?php include('../../backend/formanagement/getfooter.php'); ?>
		</div>
	</body>
	<?php
		unset($myADBConnector);
	?>
</html>