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
	
	$currentBeitrag = array();
	$currentBeitrag[0] = array();
	$currentBeitrag[0]['Sheadline'] = "";
	$currentBeitrag[0]['Sshorttext'] = "Ein kurzer Beschreibungstext...";
	$currentBeitrag[0]['Skeywords'] = "Ihre Schl&#252;ssselw&#246;rter, Kommagetrennt";
	$currentBeitrag[0]['Stext'] = "";
	$currentBeitrag[0]['CID'] = "3";
	
	$newBeitrag = TRUE;
	if(isset($_GET['SID'])) {
		$tempBeitrag = $myADBConnector->getOneBeitrag($_GET['SID']);
		if(isset($tempBeitrag[0]['SID'])) {
			$newBeitrag = FALSE;
			$currentBeitrag = $tempBeitrag;
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
				<h2>Bearbeiten oder erstellen Sie hier die Beitr&#228;ge</h2>
				<form action="save.php" method="post">
					<?php
						echo '&#220;berschrift: <input name="headline" type="text" size="30" maxlength="30" value="'.$currentBeitrag[0]['Sheadline'].'" />';
						
						$allKategorien = $myADBConnector->getChoosableKategorien();
						echo '<select name="cid" size="1">';
						foreach($allKategorien as $Kategorie) {
							if ($Kategorie['CID'] == $currentBeitrag[0]['CID'])
								echo '<option value="'.$Kategorie['CID'].'" selected>'.$Kategorie['Cname'].'</option>';
							else
								echo '<option value="'.$Kategorie['CID'].'">'.$Kategorie['Cname'].'</option>';
						}
						echo '</select><br />';
						
						echo 'Schl&#252;sselw&#246;rter: <input name="keywords" type="text" size="60" maxlength="60" value="'.$currentBeitrag[0]['Skeywords'].'" /><br />';
						echo 'Vorschautext:<br />';
						echo '<textarea name="shorttext" id="shorttext">'.$currentBeitrag[0]['Sshorttext'].'</textarea><br />';
						echo 'Ihr Beitrag:<br />';
						echo '<textarea name="text" id="text">'.$currentBeitrag[0]['Stext'].'</textarea>';
						if(!$newBeitrag)
							echo '<input type="hidden" name="ID" value="'.$_GET['SID'].'" />';
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