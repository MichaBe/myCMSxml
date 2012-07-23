<?php
	$current_dir = getcwd();
	chdir('../backend');
	include('./a_dbconnector.php');
	chdir($current_dir);
	$myADBConnector = new advanced_dbconnector();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>myCMSxml</title>
		<link rel="stylesheet" type="text/css" href="cms.css" />
	</head>
	<body>
		<div class="wrapper">
			<div class="navigation">
			</div>
			<div class="inhalt">
				<?php
					if(isset($_GET['UID'])) {
						$userToChange = $myADBConnector->getOneBenutzerByNameOrID($_GET['UID']);
						if(isset($userToChange[0]['UID'])) {
							echo '<h2>Bitte &#228;ndern Sie hier Ihr Passwort, bevor Sie fortfahren</h2>';
							if(isset($_GET['error_pw1u2']))
								echo '<div id="important_red">Die Passw&#246;rter stimmen nicht überein.</div>';
							if(isset($_GET['error_pwOwn']))
								echo '<div id="important_red">Ihr Initialpasswort wurde falsch eingegeben.</div>';
							echo '<form action="Usavepw.php" method="POST">';
							echo '<table><tr>';
							echo '<td>Ihr Initialasswort:</td><td><input type="password" name="passwSource" maxlength="20" size="20" /></td>';
							echo '</tr><tr>';
							echo '<td>Ihr Neues Passwort:</td><td><input type="password" name="Upassw1" maxlength="20" size="20" /></td>';
							echo '</tr><tr>';
							echo '<td>Neues Passwort best&#228;tigen:</td><td><input type="password" name="Upassw2" maxlength="20" size="20" /></td>';
							echo '</tr></table>';
							echo '<input type="hidden" name="UID" value="'.$userToChange[0]['UID'].'" />';
						}
					}
				?>
				<input type="submit" value="Fortfahren" />
				<input type="reset"  value="zur&#252;cksetzen" />
				</form>
			</div>
			<?php include('../backend/formanagement/getfooter.php'); ?>
		</div>
	</body>
	<?php
		unset($myADBConnector);
	?>
</html>