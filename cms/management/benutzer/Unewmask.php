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
			
			<?php include('../../backend/formanagement/getmenue.php'); ?>
			
			<div class="inhalt">
				<h2>Erstellen sie hier einen neuen Benutzer</h2>
				<?php	
					if(isset($_GET['error_name']))
						echo '<div id="important_red" align="center">Ein Benutzer mit dem gewählten Benutzername ist bereits vorhanden<br />Bitte legen Sie den Benutzer nochmals mit einem neuen Namen an.</div>';
				?>
				<form action="savenewU.php" method="post">
					<table>
						<tr>
							<td>Benutzername:</td><td><input type="text" name="Uname" size="30" maxlength="20" /></td>
						</tr>
						<tr>
							<td>Initialpasswort:</td><td><input type="text" name="Upassw" size="30" maxlength="25" /></td>
						</tr>
						<tr>
							<td colspan="2"><input type="submit" value="speichern" /><input type="reset"  value="zur&#252;cksetzen" /></td>
						</tr>
					</table>
					
				</form>	
			</div>
			<?php include('../../backend/formanagement/getfooter.php'); ?>
		</div>
	</body>
	<?php
		unset($myADBConnector);
	?>
</html>