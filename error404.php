<?php
	$current_dir = getcwd();
	chdir('cms/backend/');
	include("s_dbconnector.php");
	include("ts_cmsconnector.php");
	chdir($current_dir);
	$myConnector = new simple_dbconnector();
	$Konfiguration = $myConnector->getKonfiguration();
	$allKategories = $myConnector->getAllKategorien();
	$currentSnippet = $myConnector->getOneBeitrag(2);
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
		<?php include("/cms/style/".$Konfiguration[0]['Kvalue']."/error404.php"); ?>
	</body>
	<?php
		unset($myConnector);
	?>
</html>