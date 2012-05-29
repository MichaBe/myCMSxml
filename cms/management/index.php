<?php
	include '/cms/backend/a_dbconnector.php' ;
	$myADBConnector = new advanced_dbconnector();
	
	//authentifikation des Users
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>myCMSxml</title>
		<link rel="stylesheet" type="text/css" href="/cms/management/cms.css" />
	</head>
	<body>
		<div class="wrapper">
			<?php
				echo '<h1>Herzlich willkommen, '..'</h1>';
			?>
			<h2>Was m&#246;chten Sie tun?</h2>
			<ul>
				<?php
					<li><a href="#">Beitr&#228;ge verwalten</a></li>
					<li><a href="#">Kategorien verwalten</a></li>
					<li><a href="#">Benutzer und Berechtigungen verwalten</a></li>
					<li><a href="#">Allgemeine Konfiguration &#228;ndern</a></li>
					<li><a href="#">Ereignislog einsehen</a></li>
					<li><a href="#">Hilfe aufrufen</a></li>
					<li><a href="#">Vom System abmelden</a></li>
				?>
			</ul>
		</div>
	</body>
	<?php
		unset($myADBConnector);
	?>
</html>