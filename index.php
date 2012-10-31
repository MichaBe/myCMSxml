<?php
	$current_dir = getcwd();
	chdir('cms/backend/');
	include("s_dbconnector.php");
	include("ts_cmsconnector.php");
	chdir($current_dir);
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
			echo '<title>'.$Konfiguration[1]['Kvalue'].' - '.$curKategorie[0]['Cname'].'</title>';
			echo '<meta name="keywords" content="'.$curKategorie[0]['Ckeywords'].'" />';
			echo '<meta name="description" content="'.$curKategorie[0]['Cshorttext'].'" />';
			echo '<link rel="stylesheet" type="text/css" href="/cms/style/'.$Konfiguration[0]['Kvalue'].'/theme.css" />';
		?>
	</head>
	<body>
		<?php include("/cms/style/".$Konfiguration[0]['Kvalue']."/main.php"); ?>
	</body>
	<?php
		unset($myConnector);
	?>
</html>