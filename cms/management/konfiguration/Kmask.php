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
					$Konfiguration = $myADBConnector->getKonfiguration();
					
					$vHandle = opendir('../../style/');
					$inhalt = array();
					$i = 0;
					while($inhalt[$i] = readdir($vHandle)) {
						if(is_dir('../../style/'.$inhalt[$i]) && $inhalt[$i] != "." && $inhalt[$i] != "..")
							$i++;
					}
					closedir($vHandle);
					
					echo '<form action="save.php" method="POST">';
					echo '<table><tr>';
					echo '<td>Blogtitel:</td><td><input type="text" name="Ktitle" maxlength="20" size="77" value="'.$Konfiguration[1]['Kvalue'].'" /></td>';
					echo '</tr><tr>';
					echo '<td>Blogdesign:</td><td>';
					echo '<select name="Kstyle" size="1">';
					for($i = 0; $i < count($inhalt)-1; $i++) {
						if($inhalt[$i] == $Konfiguration[0]['Kvalue'])
							echo '<option value="'.$inhalt[$i].'" selected>'.$inhalt[$i].'</option>';
						else 
							echo '<option value="'.$inhalt[$i].'">'.$inhalt[$i].'</option>';
					}
					echo '</select></td>';
					echo '</tr><tr>';
					echo '<td colspan="2">Text für leere Kategorien:</td>';
					echo '</tr><tr>';
					echo '<td colspan="2"><textarea name="Knosnippet" id="shorttext">'.$Konfiguration[2]['Kvalue'].'</textarea></td>';
					echo '</tr><tr>';
					echo '<td colspan="2"><input type="submit" value="speichern" /><input type="reset"  value="zur&#252;cksetzen" /></td>';
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