<?php 
	include('authentification.php');
	auth('../users.xml');
?>

<?php
	$myCMSxml = simplexml_load_file("../myCMS.xml");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<?php
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			echo '<title>'.$myCMSxml->config->title.' - myCMSxml</title>';
			echo '<link rel="stylesheet" type="text/css" href="cms.css" />';
		?>
	</head>
	<body>
		<a href="logout.php" id="logout">Abmelden</a>
		<div class="inhalt">
			<?php
				echo '<a href="overview.php"><h1>'.$myCMSxml->config->title.' - myCMSxml</h1></a>';
				if(isset($_REQUEST['MESSAGE'])) {
					echo '<div class="message"><a href="#">'.$_REQUEST['MESSAGE'].'</a></div>';
				}
			?>
			<div class="snippet">
				<a href="snippets/overview.php">
					<h3>Beitr&auml;ge</h3>
					Verfassen Sie neue Beitr&auml;ge oder &auml;ndern und l&ouml;schen Sie bereits bestehende Beitr&auml;ge.
				</a>
			</div>
			<div class="snippet">
				<a href="#">
					<h3>Kategorien</h3>
					Verwalten Sie Ihre Kategorien.
				</a>
			</div>
			<div class="snippet">
				<a href="#">
					<h3>Benutzerverwaltung</h3>
					Verwalten Sie, wer welche Rechte hat. Legen Sie neue Benutzer an oder l&ouml;schen Sie bereits bestehende Benutzer.
				</a>
			</div>
			<div class="snippet">
				<a href="#">
					<h3>Allgemeine Konfiguration</h3>
					Konfigurieren Sie allgemeine Einstellungen des CMS.
				</a>
			</div>
			<div class="snippet">
				<a href="#">
					<h3>Token</h3>
					Setzen Sie einen neuen Token für den n&auml;chsten schnellen Beitrag.
				</a>
			</div>
			<div class="snippet">
				<a href="#">
					<h3>Historie</h3>
					Kontrollieren Sie die Historie anhand der gesammelten Ereignisse.
				</a>
			</div>
			<div class="snippet">
				<a href="#">
					<h3>Informationen</h3>
					Sehen Sie allgemeine Informationen wie Versionsnummer, Besitzer oder Sprache ein.
				</a>
			</div>
			<div class="snippet">
				<a href="#">
					<h3>Hilfe</h3>
					Sehen Sie die Hilfeartikel ein, um alle M&ouml;glichkeiten von myCMSxml nutzen zu k&ouml;nnen.
				</a>
			</div>
		</div>
	</body>
</html>