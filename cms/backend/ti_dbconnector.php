<?php
	/* Theme-Installation-DB-Conenctor. Entwickelt für die Installation von Themes in das CMS */
	
	$globalConfig = include('config.php');
	
	class TI_dbconnector {
		private $connection_ID;
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
		
		public function setError404($pagebody) {
			$query = sprintf("UPDATE Beitrag
				SET Stext = '%s'
				WHERE SID = 2",
				mysql_real_escape_string($pagebody));
			mysql_query($query, $this->connection_ID);
		}
		
		public function setFooterCall($newname) {
			$query = sprintf("UPDATE Kategorie
				SET Cname = '%s'
				WHERE CID = 1",
				mysql_real_escape_string($newname));
			mysql_query($query, $this->connection_ID);
		}
		
		public function setStartseiteCall($newname) {
			$query = sprintf("UPDATE Kategorie
				SET Cname = '%s'
				WHERE CID = 4",
				mysql_real_escape_string($newname));
			mysql_query($query, $this->connection_ID);
		}
		
		public function setnoBeitrag($pagebody) {
			$query = sprintf("UPDATE Konfiguraiton
				SET Knosnippet = '%s'
				WHERE KID = 1",
				mysql_real_escape_string($pagebody));
			mysql_query($query, $this->connection_ID);
		}
		
		public function addMOTD($MOTD) {
			$query = sprintf("INSERT INTO MOTD
				VALUES(NULL, 'STYLE', '%s')",
				mysql_real_escape_string($MOTD));
			mysql_query($query, $this->connection_ID);
		}
		
		
	}
?>