<?php 
	include('../authentification.php');
	auth('../../users.xml');
?>

<?php
	$myCMSxml = simplexml_load_file("../../myCMS.xml");
	$catXML = simplexml_load_file("../../categories.xml");
	//POST gesetzt?? (/GET)
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
			<form action="generate.php" method="post">
				<table width="auto">
					<tr>
						<td>Kategorie:</td>
						<td>
							<select name="categorie" size="1">
								<?php
									for($i = 0; $i < count($catXML->category); $i++) {
										echo '<option value="'.$catXML->category[$i]->id.'">'.$catXML->category[$i]->showname.'</option>';
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Schlagw&ouml;rter (Durch Komma getrennt):</td>
						<td><input type="text" name="tags" maxlength="50" size="60"/></td>
					</tr>
					<tr>
						<td>&Uuml;berschrift:</td>
						<td><input type="text" name="headline" maxlength="50" size="60"/></td>
					</tr>
					<tr>
						<td colspan="2"><textarea cols="100" rows="4" name="shorttext">Schreiben Sie hier den Vorschautext...</textarea></td>
					</tr>
					<tr>
						<td colspan="2"><textarea cols="100" rows="40" name="text">Verfassen Sie hier ihren Text...</textarea></td>
					</tr>
					<tr>
						<td>Status:</td>
						<td>
							<select name="status" size="1">
								<option value="released">veröffentlicht</option>
								<option value="hidden">versteckt</option>
								<option value=""></option>
							</select>
						/td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" value="Zur Vorschau" /><input type="reset" value="Alle Eingaben verwerfen" /></td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>