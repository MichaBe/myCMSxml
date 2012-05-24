<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head><title>myCMS.xml</title></head>
	<body>
		<h1>Diese Seite ist noch im Aufbau. Bitte gedulden sie sich noch ein bisschen ;)</h1>
		Besuchen sie währenddessen doch meine anderen Seiten:
		<ul>
			<li><a href="http://www.photovalley.de">photovalley.de</a></li>
			<li><a href="http://www.codingmountain.de">codingmountain.de</a></li>
		</ul>
		<form action="index2.php" method="post">
			<input type="text" name="unmd5t"/>
			<input type="submit" value="md5.2 Berechnen" />
		</form>
		<form action="index2.php" method="post">
			<input type="datetime" name="datum"/>
			<input type="submit" value="Zeitstempel ausgeben"/>
		</form>
		<?php
		if($_POST["unmd5t"])
			echo md5(md5($_POST["unmd5t"]));
		if($_POST["datum"])
			echo strtotime($_POST["datum"]);
		?>
	</body>
</html>