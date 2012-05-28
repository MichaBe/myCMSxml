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
		
		public function getAllBenutzer() {
			$query = "SELECT UID, Uname 
				FROM Benutzer";
			$result = mysql_query($query, $this->connection_ID);
			$i = 0;
			$returnarray = array();
			while($row = mysql_fetch_assoc($result)){
				$returnarray[$i] = $row;
				$i++;
			}
			return $returnarray;
		}
		public function getOneBenutzer($UID) {
			$query = sprintf("SELECT Benutzer.UID, Uname, XID, Xvalue, Rtopic
				FROM Rolle, Berechtigung, Benutzer
				WHERE Benutzer.UID = Berechtigung.UID
				AND ROLLE.RID = Berechtigung.RID
				AND Benutzer.UID = %d", $UID);
			$result = mysql_query($query, $this->connection_ID);
			$i = 0;
			$returnarray = array();
			while($row = mysql_fetch_assoc($result)){
				$returnarray[$i] = $row;
				$i++;
			}
			return $returnarray;
		}
	}
?>