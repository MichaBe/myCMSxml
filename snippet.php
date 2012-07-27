<?php
	$current_dir = getcwd();
	chdir('cms/backend/');
	include("s_dbconnector.php");
	chdir($current_dir);
	$myConnector = new simple_dbconnector();
	$Konfiguration = $myConnector->getKonfiguration();
	$allKategories = $myConnector->getAllKategorien();
	$allSnippets = $myConnector->getShortBeitraege("ALL");
	$validsnippetchoosen = FALSE;
	$currentSnippet;
	if(isset($_REQUEST['SID'])) {
		foreach ($allSnippets as $cursnippet) {
			if($cursnippet['SID'] == $_REQUEST['SID']) {
				$validsnippetchoosen = TRUE;
				$currentSnippet = $myConnector->getOneBeitrag($cursnippet['SID']);
			}
		}
	}
	if(!isset($_REQUEST['SID']) || !$validsnippetchoosen) {
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/error404.php');
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php
			echo '<title>'.$Konfiguration[1]['Kvalue'].' - '.$currentSnippet[0]['Sheadline'].'</title>';
			echo '<meta name="keywords" content="'.$currentSnippet[0]['Skeywords'].'" />';
			echo '<meta name="description" content="'.$currentSnippet[0]['Sshorttext'].'" />';
			echo '<link rel="stylesheet" type="text/css" href="/cms/style/'.$Konfiguration[0]['Kvalue'].'/theme.css" />';
		?>
	</head>
	<body>
		<div class="wrapper">
			<div class="header">
				<?php
					echo $Konfiguration[1]['Kvalue'];
				?>
			</div>
			<div class="categories">
				<ul>
					<?php
						foreach ($allKategories as $curKat) {
							echo '<li id="C'.$curKat['CID'].'"><a href="'.$curKat['Ctarget'].'.php?CID='.$curKat['CID'].'">'.$curKat['Cname'].'</a></li>';
						}
					?>
				</ul>
			</div>
			<div class="inhalt">
				<?php
					echo '<div class="snippet" id="'.$currentSnippet[0]['SID'].'">';
					echo '<h2>'.$currentSnippet[0]['Sheadline'].'</h2>';
					echo '<div class="s_header">';
					echo 'Ver&#246;ffentlicht am '.$currentSnippet[0]['Sreleased'].' von '.$currentSnippet[0]['Uname'].', letzte Änderung am '.$currentSnippet[0]['Slastmod'];
					echo '</div>';
					echo $currentSnippet[0]['Stext'];
					echo '</div>';
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