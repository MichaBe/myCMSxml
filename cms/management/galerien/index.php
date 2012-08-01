<?php
	session_start();
	session_regenerate_id(TRUE);
	$current_dir = getcwd();
	chdir('../../backend');
	include('./a_dbconnector.php');
	chdir($current_dir);
	$myADBConnector = new advanced_dbconnector();
	$currentRights = $myADBConnector->getOneBenutzer($_SESSION['UID']);
	
	if($currentRights[6]['Xvalue'] != 1) {
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
				<h2>Erstellen oder bearbeiten Sie hier Galerien</h2>
				<?php
					$allGalerien = $myADBConnector->getAllGalerien();
					echo '<a href="Gmask.php" id="important_green">Neue Galerie</a>';
					if(isset($allGalerien[0]['CID']))
						echo '&nbsp;<a href="BGnewmask.php" id="important_green">Neue Bildgruppe</a>';
					
					echo '<table>';
					foreach($allGalerien as $curGalerie) {
						echo '<tr>';
						echo '<th colspan="2">'.$curGalerie['Cname'].'</th>';
						echo '<th>Bildgruppen: '.$curGalerie['BGcount'].'</th>';
						echo '<th id="important_green"><a href="Gmask.php?CID='.$curGalerie['CID'].'">bearbeiten</a></th>';
						
						$allBildgruppen = $myADBConnector->getOnesBildgruppen($curGalerie['CID']);
						if(!isset($allBildgruppen[0]['BGID'])) {
							echo '<th id="important_red"><a href="Gdelete.php?CID='.$curGalerie['CID'].'">l&#246;schen</a></th></th>';
						}
						else {
							echo '<th>l&#246;schen</th></tr>';
							
							foreach($allBildgruppen as $curBildgruppe) {
								echo '<tr><td id="important_green">&nbsp;</td>';
								echo '<td>'.$curBildgruppe['BGname'].'</td>';
								echo '<td>Bilder: '.$curBildgruppe['Bcount'].'</td>';
								echo '<td id="important_green"><a href="BGmask.php?BGID='.$curBildgruppe['BGID'].'">bearbeiten</a></td>';
								if($curBildgruppe['Bcount'] == 0)
									echo '<td id="important_red"><a href="BGdelete.php?BGID='.$curBildgruppe['BGID'].'">l&#246;schen</a></td>';
								else
									echo '<td>l&#246;schen</td>';
								echo '</tr>';
							}
						}
					}
					echo '</table>';
				?>
			</div>
			<?php include('../../backend/formanagement/getfooter.php'); ?>
		</div>
	</body>
	<?php
		unset($myADBConnector);
	?>
</html>