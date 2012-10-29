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
	
	$allGalerien = $myADBConnector->getAllGalerien();
	if(!isset($allGalerien[0]['CID']))
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/galerien/index.php');
	
	$currentBG = array();
	$currentBG[0] = array();
	$currentBG[0]['BGname'] = "";
	$currentBG[0]['CID'] = $allGalerien[0]['CID'];
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
				<h2>Erstellen oder bearbeiten Sie hier Bildgruppen</h2>
				<form action="BGsave.php" method="post">
				<?php
					echo '<table>';
					echo '<tr><td>Name der Bildgruppe:</td>';
					echo '<td><input name="name" type="text" size="50" maxlength="30" value="'.$currentBG[0]['BGname'].'" /></td></tr>';
					
					echo '<tr><td>In Galerie:</td>';
					echo '<td><select name="CID" size="1">';
					foreach($allGalerien as $curGalerie) {
						if($curGalerie['CID'] == $currentBG[0]['CID'])
							echo '<option value="'.$curGalerie['CID'].'" selected>'.$curGalerie['Cname'].'</option>';
						else
							echo '<option value="'.$curGalerie['CID'].'">'.$curGalerie['Cname'].'</option>';
					}
					echo '</select></td>';
					echo '</tr><tr>';
					echo '<td colspan="2"><input type="submit" value="speichern" />';
					echo '<input type="reset"  value="zur&#252;cksetzen" /></td>';
					echo '</tr></table>';
				?>
				</form>
			</div>
			<?php include('../../backend/formanagement/getfooter.php'); ?>
		</div>
	</body>
	<?php
		unset($myADBConnector);
	?>
</html>