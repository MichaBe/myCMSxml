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
				<?php
					if(isset($_GET['UID'])) {
						$userToChange = $myADBConnector->getOneBenutzerByNameOrID($_GET['UID']);
						if(isset($userToChange[0]['UID'])) {
							echo '<h2>&#196;ndern Sie hier das Passwort f&#252;r "'.$userToChange[0]['Uname'].'"</h2>';
							if(isset($_GET['error_pw1u2']))
								echo '<div id="important_red">Die Passw&#246;rter für den neuen Benutzer stimmen nicht überein.</div>';
							if(isset($_GET['error_pwOwn']))
								echo '<div id="important_red">Ihr Passwort wurde falsch eingegeben.</div>';
							echo '<form action="PWsave.php" method="POST">';
							echo '<table><tr>';
							echo '<td>Ihr Passwort:</td><td><input type="password" name="passwSource" maxlength="20" size="20" /></td>';
							echo '</tr><tr>';
							echo '<td>Neues Passwort f&#252r "'.$userToChange[0]['Uname'].'":</td><td><input type="password" name="Upassw1" maxlength="20" size="20" /></td>';
							echo '</tr><tr>';
							echo '<td>Neues Passwort best&#228;tigen:</td><td><input type="password" name="Upassw2" maxlength="20" size="20" /></td>';
							echo '</tr></table>';
							echo '<input type="hidden" name="UID" value="'.$userToChange[0]['UID'].'" />';
						}
					}
				?>
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