<?php
//simple DB-Connector. Enthält die für das Frontend nötigen Funktionen

	$globalConfig = include('config.php');
	
	class simple_dbconnector {
		
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
		
		public function getAllKategorien() {
			$query = "SELECT CID, Cname 
				FROM Kategorie 
				WHERE CID != 1 
				AND CID != 2 
				AND CID != 3";
			$result = mysql_query($query, $this->connection_ID);
			$i = 0;
			$returnarray = array();
			while($row = mysql_fetch_assoc($result)){
				$returnarray[$i] = $row;
				$i++;
			}
			return $returnarray;
		}
		
		public function getOneKategorie($CID) {
			$query = sprintf("SELECT * 
				FROM Kategorie 
				WHERE CID = %d", 
				mysql_real_escape_string($CID));
			$result = mysql_query($query, $this->connection_ID);
			$i = 0;
			$returnarray = array();
			while($row = mysql_fetch_assoc($result)){
				$returnarray[$i] = $row;
				$i++;
			}			
			return $returnarray;
		}
		
		public function getShortBeitraege($CID) {
			$query;
			if($CID == "ALL") {
				$query = sprintf("SELECT SID, Uname, Cname, Sheadline, Sshorttext, Slastmod, Sreleased 
					FROM Benutzer, Beitrag, Kategorie 
					WHERE Benutzer.UID = Beitrag.UID 
					AND Beitrag.CID = Kategorie.CID 
					AND Beitrag.CID != 3 
					ORDER BY Slastmod DESC, Sreleased DESC");
			}
			elseif($CID == 4) {
				$query = sprintf("SELECT SID, Uname, Cname, Sheadline, Sshorttext, Slastmod, Sreleased 
					FROM Benutzer, Beitrag, Kategorie 
					WHERE Benutzer.UID = Beitrag.UID 
					AND Beitrag.CID = Kategorie.CID 
					AND Beitrag.CID != 1 
					AND Beitrag.CID != 2 
					AND Beitrag.CID != 3 
					ORDER BY Slastmod DESC, Sreleased DESC");
			}
			else {
				$query = sprintf("SELECT SID, Uname, Cname, Sheadline, Sshorttext, Slastmod, Sreleased 
				FROM Benutzer, Beitrag, Kategorie 
				WHERE Benutzer.UID = Beitrag.UID 
				AND Beitrag.CID = Kategorie.CID 
				AND Beitrag.CID = %d 
				AND Beitrag.CID != 1 
				AND Beitrag.CID != 2 
				AND Beitrag.CID != 3 
				ORDER BY Slastmod DESC, Sreleased DESC", 
				mysql_real_escape_string($CID));
			}
			$result = mysql_query($query, $this->connection_ID);
			$i = 0;
			$returnarray = array();
			while($row = mysql_fetch_assoc($result)){
				$returnarray[$i] = $row;
				$i++;
			}
			return $returnarray;
		}
		
		public function getOneBeitrag($SID) {
			$query = sprintf("SELECT SID, Uname, Cname, Sheadline, Sshorttext, Stext, Slastmod, Sreleased, Skeywords 
				FROM Benutzer, Beitrag, Kategorie 
				WHERE Benutzer.UID = Beitrag.UID 
				AND Beitrag.SID = %d 
				AND Beitrag.CID = Kategorie.CID 
				AND Beitrag.CID != 3", 
				mysql_real_escape_string($SID));
			$result = mysql_query($query, $this->connection_ID);
			$i = 0;
			$returnarray = array();
			while($row = mysql_fetch_assoc($result)){
				$returnarray[$i] = $row;
				$i++;
			}
			return $returnarray;
		}
		
		public function getforFooter() {
			$query = "SELECT SID, Sheadline 
				FROM Beitrag 
				WHERE CID = 1";
			$result = mysql_query($query, $this->connection_ID);
			$i = 0;
			$returnarray = array();
			while($row = mysql_fetch_assoc($result)){
				$returnarray[$i] = $row;
				$i++;
			}
			return $returnarray;
		}
		
		public function getKonfiguration() {
			$query = "SELECT * 
				FROM Konfiguration 
				WHERE KID = 1";
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