<?php
	include "/cms/backend/dbconnector.php";
	$mDBc = new simple_dbconnector();
	$result = $mDBc->getOneBeitrag(3);
	var_dump($result);
	unset($mDBc);
?>