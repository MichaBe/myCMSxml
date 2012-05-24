<?php
	include('../authentification.php');
	auth('../../users.xml');
?>
<?php
	$myCMSxml = simplexml_load_file("../../myCMS.xml");
	$catXML = simplexml_load_file("../../categories.xml");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<?php
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			echo '<title>'.$myCMSxml->config->title.' - myCMSxml</title>';
			echo '<link rel="stylesheet" type="text/css" href="../cms.css" />';
		?>
	</head>
	<body>
		<a href="../logout.php" id="logout">Abmelden</a>
		<div class="inhalt">
			<?php
				echo '<a href="../overview.php"><h1>'.$myCMSxml->config->title.' - myCMSxml</h1></a>';
			?>
			<table>
				<tr>
					<th>ID</th>
					<th>Status</th>
					<th>Überschrift</th>
					<th>Author</th>
					<th>Veröffentlicht</th>
					<th>Letzte Änderung</th>
				</tr>
				<?php
					
				?>
			</table>
		</div>
	</body>
</html>