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
	
	$newUser = TRUE;
	$UserToChange = array();
	
	if(isset($_GET['UID'])) {
		$UserToChange = $myADBConnector->getOneBenutzerByNameOrID($_GET['UID']);
		if(isset($UserToChange[0]['UID'])) {
			$UserToChange = $myADBConnector->getOneBenutzer($_GET['UID']);
			$newUser = FALSE;
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
				<h2>Bearbeiten oder erstellen Sie hier einen Benutzer</h2>
				<form action="save.php" method="post">
					<?php
						$rights = $myADBConnector->getAllPossibleRights();
						if($newUser) {
							echo 'Benutzername: <input type="text" size="20" maxlength="20" /><br />';
							echo 'Initialpasswort: <input type="password" size="40" maxlength="20" /><br />';
							foreach($rights as $currright) {
								echo '<br />'.$currright['Rtopic'].'<br />';
								echo '<input type="radio" name="'.$currright['RID'].'" value="1" />berechtigt<br />';
								echo '<input type="radio" name="'.$currright['RID'].'" value="0" checked />nicht berechtigt<br />';
							}
						}
						else {
							$curruser = $myADBConnector->getOneBenutzerByNameORID($_GET['UID']);
							echo 'Benutzername: <input type="text" size="20" maxlength="20" value="'.$curruser[0]['Uname'].'" /><br />';
							echo 'Passwort (wenn &#196;nderung notwendig): <input type="password" size="20" maxlength="20" /><br />';
							foreach ($rights as $currright) {
								echo '<br />'.$currright['Rtopic'].'<br />';
								if($UserToChange[0]['Xvalue'] == 1) {
									echo '<input type="radio" name="'.$currright['RID'].'" value="1" checked />berechtigt<br />';
									echo '<input type="radio" name="'.$currright['RID'].'" value="0" />nicht berechtigt<br />';
								}
								else {
									echo '<input type="radio" name="'.$currright['RID'].'" value="1" />berechtigt<br />';
									echo '<input type="radio" name="'.$currright['RID'].'" value="0" checked />nicht berechtigt<br />';
								}
							}
							echo '<input type="hidden" name="UID" value="'.$_GET['UID'].'" />'; //Verstecktes feld mit UID
						}
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