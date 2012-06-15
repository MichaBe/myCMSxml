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
	
	$currentKategorie = array();
	$currentKategorie[0] = array();
	$currentKategorie[0]['Cshorttext'] = "Ein kurzer Beschreibungstext...";
	$currentKategorie[0]['Cname'] = "";
	$currentKategorie[0]['Ckeywords'] = "Ihre Schl&#252;ssselw&#246;rter, Kommagetrennt";
	
	$newKategorie = TRUE;
	if(isset($_GET['CID'])) {
		$tempKategorie = $myADBConnector->getOneKategorie($_GET['CID']);
		if(isset($tempKategorie[0]['CID'])) {
			$newKategorie = FALSE;
			$currentKategorie = $tempKategorie;
		}
	}
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
				<h2>Bearbeiten oder erstellen Sie hier die Kategorien</h2>
				<form action="save.php" method="post">
					<?php
						echo 'Name: <input name="name" type="text" size="20" maxlength="20" value="'.$currentKategorie[0]['Cname'].'" /><br />';
												
						echo 'Schl&#252;sselw&#246;rter: <input name="keywords" type="text" size="60" maxlength="60" value="'.$currentKategorie[0]['Ckeywords'].'" /><br />';
						echo 'Vorschautext:<br />';
						echo '<textarea name="shorttext" id="shorttext">'.$currentKategorie[0]['Cshorttext'].'</textarea><br />';
						if(!$newKategorie)
							echo '<input type="hidden" name="ID" value="'.$_GET['CID'].'" />';
					?>
					<br />
					<input type="submit" value="speichern" />
					<input type="reset"  value="zur&#252;cksetzen" />
				</form>	
			</div>
			<?php include('../../backend/formanagement/getfooter.php'); ?>
		</div>
	</body>
	<?php
		unset($myADBConnector);
	?>
</html>