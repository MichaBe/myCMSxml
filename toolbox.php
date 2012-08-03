<?php
	if(isset($_POST['unmd5'])) {
		echo md5(md5($_POST['unmd5']));
	}
	echo var_dump($_FILES['ftp_datei']);
?>
<form action="toolbox.php" method="post">
	<input type="text" name="unmd5" />
	<input type="submit" value="md5²" />
</form>