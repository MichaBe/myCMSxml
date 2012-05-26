<?php
	include("cms/backend/s_dbconnector.php");
	$myConnector = new simple_dbconnector();
	$Konfiguration = $myConnector->getKonfiguration();
	$allKategories = $myConnector->getAllKategorien();
	$validKatChoosen = FALSE;
	$curKategorie = $myConnector->getOneKategorie(4);
	
	if(isset($_REQUEST['CID'])) {
		foreach($allKategories as $curKat) {
			if($curKat['CID'] == $_REQUEST['CID']) {
				$validKatChoosen = TRUE;
				$curKategorie = $myConnector->getOneKategorie($curKat['CID']);
				break;
			}
		}
	}
	if (isset($_REQUEST['CID']) && !$validKatChoosen) {
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/error404.php');
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php
			echo '<title>'.$Konfiguration[0]['PageTitle'].' - '.$curKategorie[0]['Cname'].'</title>';
			echo '<meta name="keywords" content="'.$curKategorie[0]['Ckeywords'].'" />';
			echo '<meta name="description" content="'.$curKategorie[0]['Cshorttext'].'" />';
			echo '<link rel="stylesheet" type="text/css" href="/cms/style/'.$Konfiguration[0]['Kstyle'].'/theme.css" />';
		?>
	</head>
	<body>
		<div class="wrapper">
			<div class="header">
				<?php
					echo $Konfiguration[0]['Ktitle'];
				?>
			</div>
			<div class="categories">
				<ul>
					<?php
						foreach ($allKategories as $curKat) {
							echo '<li id="C'.$curKat['CID'].'"><a href="index.php?CID='.$curKat['CID'].'">'.$curKat['Cname'].'</a></li>';
						}
					?>
				</ul>
			</div>
			<div class="inhalt">
				<?php
					$Beitraege = $myConnector->getShortBeitraege($curKategorie[0]['CID']);
					
					foreach ($Beitraege as $curBeitrag) {
						echo '<div class="snippet" id="'.$curBeitrag['SID'].'">';
						echo '<h2>'.$curBeitrag['Sheadline'].'</h2>';
						echo '<div class="s_header">';
						echo 'Ver&#246;ffentlicht am '.$curBeitrag['Sreleased'].' von '.$curBeitrag['Uname'].', letzte Änderung am '.$curBeitrag['Slastmod'];
						echo '</div>';
						echo '<a href="snippet.php?SID='.$curBeitrag['SID'].'">';
						echo $curBeitrag['Sshorttext'];
						echo '</a>';
						echo '</div>';
					}
				?>
			</div>
			<div class="footer">
				<ul>
					<?php
						$footer = $myConnector->getforFooter();
						foreach ($footer as $shorts) {
							echo '<li><a href="snippet.php?SID='.$shorts['SID'].'">'.$shorts['Sheadline'].'</a></li>';
						}
					?>
				</ul>
			</div>
		</div>
	</body>
	<?php
		unset($myConnector);
	?>
</html>