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
	
	$currentBG = array();
	if(isset($_GET['BGID'])) {
		$currentBG = $myADBConnector->getOneBildgruppe($_GET['BGID']);
		if(!isset($currentBG[0]['BGID'])) {
			header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/galerien/index.php');
		}
	}
	else {
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/cms/management/galerien/index.php');
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
				<h2>Bearbeiten Sie hier die Bildgruppe</h2>
				<?php
					$allBilder = $myADBConnector->getOnesBilder($currentBG[0]['BGID']);
					$allGalerien = $myADBConnector->getAllGalerien();
					echo '<table><form action="BGsave.php" method="post"><tr>';
					echo '<th colspan="10">Name: <input name="name" type="text" size="50" maxlength="30" value="'.$currentBG[0]['BGname'].'" />';
					echo 'in ';
					echo '<select name="CID" size="1">';
					foreach($allGalerien as $curGalerie) {
						if($curGalerie['CID'] == $currentBG[0]['CID'])
							echo '<option value="'.$curGalerie['CID'].'" selected>'.$curGalerie['Cname'].'</option>';
						else
							echo '<option value="'.$curGalerie['CID'].'">'.$curGalerie['Cname'].'</option>';
					}
					echo '<input name="ID" type="hidden" value="'.$currentBG[0]['BGID'].'" />';
					echo '<input type="submit" value="speichern" /> <input type="reset"  value="zur&#252;cksetzen" />';
					echo '</th></tr></form>';
					echo '<tr><th colspan="10">Um ein Bild als Vorschaubild für die Bildgruppe auszuwählen, klicken Sie auf das Bild:</th></tr>';
					
					$countZeilen = ((count($allBilder)-count($allBilder)%5)/5)+1;
					if(count($allBilder)%5 == 0)
						$countZeilen--;
					
					for($i = 0; $i < $countZeilen; $i++) {
						echo '<tr>';
						for($j = 0; $j < 5; $j++) {
							if(isset($allBilder[$i*5+$j]['BID'])) {
								echo '<td colspan="2"><a href="BGthumb.php?BID='.$allBilder[$i*5+$j]['BID'].'&BGID='.$currentBG[0]['BGID'].'"><img src="../../bilder/B'.$allBilder[$i*5+$j]['BID'].'thmb.jpg" /></a></td>';
							}
							else {
								echo '<td colspan="'.((5-$j)*2).'"></td>';
								break;
							}
						}
						echo '</tr><tr>';
						for($j = 0; $j < 5; $j++) {
							if(isset($allBilder[$i*5+$j]['BID'])) {
								echo '<td id="important_green"><a href="Bchange.php?BID='.$allBilder[$i*5+$j]['BID'].'&BGID='.$currentBG[0]['BGID'].'">bearbeiten</a></td>';
								echo '<td id="important_red"><a href="Bdelete.php?BID='.$allBilder[$i*5+$j]['BID'].'&BGID='.$currentBG[0]['BGID'].'">l&#246;schen</a></td>';
							}
							else {
								echo '<td colspan="'.((5-$j)*2).'"></td>';
								break;
							}
						}
						echo '</tr>';
					}
					echo '<tr><td colspan="10">';
					echo '<form action="Bnewsave.php" method="post" enctype="multipart/form-data"><input type="hidden" name="BGID" value="'.$currentBG[0]['BGID'].'" /><input name="sourcepath" type="file" size="50" maxlength="10000" accept="image/jpg" /><input type="submit" value="Bild hochladen" /></form>';
					echo '</td></tr>';
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