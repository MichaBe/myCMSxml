<?php
//Advanced DB-Connector. Nur für die Benutzung in verbindung mit dem Backend des CMS

	$globalConfig = include('/cms/backend/config.php');
	
	class advanced_dbconnector {
		private $connectionID;
		private $globalConfig;
		
		public function __construct() {
			$this->globalConfig = $GLOBALS["globalConfig"];				
			$this->connection_ID = mysql_connect($this->globalConfig["db_server"], $this->globalConfig["db_user"], $this->globalConfig["db_passwd"]);
			
			if($this->connection_ID != FALSE) {
				mysql_query(sprintf("USE %s", mysql_real_escape_string($this->globalConfig["db_scheme"])), $this->connection_ID);
			}
			else {
				return FALSE;
			}
		}
		
		public function __desctruct() {
			mysql_close($this->connection_ID);
		}
		
		
	}
?>