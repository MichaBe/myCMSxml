<?php
	function dbinit($conectID, $dbtoUse, $HELP){
		$querys = array(
			sprintf("USE %s",mysql_real_escape_string($dbtoUse)),
			//Hier müssen noch die Befehle übertragen werden!!
		);
		
		$help_querys = array(
		""
		);
		
		
		foreach($querys as $qtoUse){
			mysql_query($qtoUse, $conectID);
		}
		
		if($HELP){
			foreach($help_querys as $helpq){
				mysql_query($helpq, $conectID);
			}
		}
	}
?>