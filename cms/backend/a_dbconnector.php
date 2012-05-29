<?php
//Advanced DB-Connector. Nur für die Benutzung in verbindung mit dem Backend des CMS

	$globalConfig = include('config.php');
	
	class advanced_dbconnector {
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
		
		public function getAllBenutzer() {
			$query = "SELECT UID, Uname 
				FROM Benutzer
				ORDER BY Uname";
			$result = mysql_query($query, $this->connection_ID);
			$i = 0;
			$returnarray = array();
			while($row = mysql_fetch_assoc($result)){
				$returnarray[$i] = $row;
				$i++;
			}
			return $returnarray;
		}
		public function getOneBenutzerByName($Uname) {
			$query = sprintf("SELECT *
				FROM Benutzer
				WHERE Uname = '%s'", $Uname);
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
			$query = sprintf("SELECT XID, Xvalue, Rtopic
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
		
		public function getAllKategorien() {
			$query = "SELECT CID, Cname, Ckeywords 
				FROM Kategorie
				ORDER BY Cname";
			$result = mysql_query($query, $this->connection_ID);
			$i = 0;
			$returnarray = array();
			while($row = mysql_fetch_assoc($result)){
				$returnarray[$i] = $row;
				$i++;
			}
			return $returnarray;
		}
		public function getChoosableKategorien() {
			$query = "SELECT CID, Cname 
				FROM Kategorie
				WHERE CID != 4
				ORDER BY CID DESC";
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
			$query = sprintf("SELECT CID, Cshorttext, Cname, Ckeywords
				FROM Kategorie
				WHERE CID = %d", $CID);
			$result = mysql_query($query, $this->connection_ID);
			$i = 0;
			$returnarray = array();
			while($row = mysql_fetch_assoc($result)){
				$returnarray[$i] = $row;
				$i++;
			}
			return $returnarray;
		}
		
		public function getAllBeitraege() {
			$query = "SELECT SID, Uname, Cname, Sheadline, Slastmod, Sreleased
				FROM Benutzer, Beitrag, Kategorie
				WHERE Benutzer.UID = Beitrag.UID
				AND Kategorie.CID = Beitrag.CID
				ORDER BY Slastmod DESC, Sreleased DESC";
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
			$query = sprintf("SELECT SID, Cname, CID, Sheadline, Sshorttext, Stext, Skeywords
				FROM Beitrag, Kategorie
				WHERE Beitrag.CID = Kategorie.CID
				AND Beitrag.SID = %d", $SID);
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
		
		public function getAllEreignisse() {
			$query = "SELECT * 
				FROM Ereignis
				ORDER BY Etime DESC, EID DESC";
			$result = mysql_query($query, $this->connection_ID);
			$i = 0;
			$returnarray = array();
			while($row = mysql_fetch_assoc($result)){
				$returnarray[$i] = $row;
				$i++;
			}
			return $returnarray;
		}
		
		public function getAllHilfeKategorien() {
			$query = "SELECT HCID, HCname
				FROM Hilfekategorie
				ORDER BY HCname";
			$result = mysql_query($query, $this->connection_ID);
			$i = 0;
			$returnarray = array();
			while($row = mysql_fetch_assoc($result)){
				$returnarray[$i] = $row;
				$i++;
			}
			return $returnarray;
		}
		public function getHilfeBeitraege($HCID) {
			$query = sprintf("SELECT HSID, HSheadline, HStext
				FROM Hilfebeitrag
				WHERE HCID = %d
				ORDER BY HSheadline", $HCID);
			$result = mysql_query($query, $this->connection_ID);
			$i = 0;
			$returnarray = array();
			while($row = mysql_fetch_assoc($result)){
				$returnarray[$i] = $row;
				$i++;
			}
			return $returnarray;
		}
		
		
		public function changeOneBenutzer($UID, $Berechtigungen) {
			$query = array();
			for($i = 0; $i < count($Berechtigungen); $i++) {
				$query[$i] = sprintf("UPDATE Berechtigung
					SET Xvalue = %d
					WHERE RID = %d
					AND UID = %d", $Berechtigung[$i]['Xvalue'], $Berechtigung[$i]['RID'], $UID);
			}
			foreach($query as $curQuery) {
				mysql_query($curQuery, $this->connection_ID);
			}
		}
		public function addOneBenutzer($Uname, $upassw, $Berechtigungen) {
			$query = sprintf("INSERT INTO Benutzer 
				VALUES(NULL, '%s', '%s')", $Uname, $upassw);
			mysql_query($query, $this->connection_ID);
			$UID = mysql_insert_id($this->connection_ID);
			
			$query = array();
			for($i = 0; $i < count($Berechtigungen); $i++) {
				$query[$i] = sprintf("INSERT INTO Berechtigung
					VALUES(NULL, %d, %d, %d)", $UID, $Berechtigung[$i]['RID'], $Berechtigung[$i]['Xvalue']);
			}
			foreach($query as $curQuery) {
				mysql_query($curQuery, $this->connection_ID);
			}
			return $UID;
		}
		public function delOneBenutzer($UID) {
			$query[0] = sprintf("DELETE FROM Berechtigung
				WHERE UID = %d
				AND UID != 1", $UID);
			$query[1] = sprintf("DELETE FROM Benutzer
				WHERE UID = %d
				AND UID != 1", $UID);
			
			foreach($query as $curQuery) {
				mysql_query($curQuery, $this->connection_ID);
			}
		}
		
		public function addOneKategorie($Kategorie) {
			$query = sprintf("INSERT INTO Kategorie
				VALUES(NULL, '%s', '%s', '%s')", $Kategorie['Cshorttext'], $Kategorie['Cname'], $Kategorie['Ckeywords']);
			mysql_query($query, $this->connection_ID);
		}
		public function delOneKategorie($CID) {
			$query = sprintf("DELETE FROM Kategorie
				WHERE CID = %d
				AND CID != 1
				AND CID != 2
				AND CID != 3
				AND CID != 4", $CID);
			mysql_query($query, $this->connection_ID);
		}
		
		public function changeOneBeitrag($SID, $Beitrag) {
			$query = sprintf("UPDATE Beitrag
				SET CID = %d,
				Sheadline = '%s',
				Sshorttext = '%s',
				Stext = '%s',
				Slastmod = CURDATE(),
				Skeywords = '%s'
				WHERE SID = %d", $Beitrag['CID'], $Beitrag['Sheadline'], $Beitrag['Sshorttext'], $Beitrag['Stext'], $Beitrag['Skeywords'], $SID);
			mysql_query($query, $this->connection_ID);
		}
		public function addOneBeitrag($Beitrag) {
			$query = sprintf("INSERT INTO Beitrag
				VALUES(NULL, %d, %d, '%s', '%s', '%s', CURDATE(), CURDATE(), Skeywords = '%s'",$Beitrag['UID'], $Beitrag['CID'], $Beitrag['Sheadline'], $Beitrag['Sshorttext'], $Beitrag['Stext'], $Beitrag['Skeywords']);
			mysql_query($query, $this->connection_ID);
		}
		public function delOneBeitrag($SID) {
			$query = sprintf("DELETE FROM Beitrag
				WHERE SID = %d
				AND SID != 1
				AND SID != 404", $SID);
			mysql_query($query, $this->connection_ID);
		}
		
		public function changeKonfiguration($Konfiguration) {
			$query = sprintf("UPDATE Konfiguration
				SET Kstylename = '%s',
				Kpagetitle = '%s',
				Klanguage = '%s',
				Knosnippet = %s'
				WHERE KID = 1", $Konfiguration['Kstylename'], $Konfiguration['Kpagetitle'],$Konfiguration['Klanguage'], $Konfiguration['Knosnippet']);
			mysql_query($query, $this->connection_ID);
		}
		
		public function addEreignis($Etext) {
			$query = sprintf("INSERT INTO Ereignis
				VALUES(NULL, CURDATE(), '%s')", $Etext);
			mysql_query($query, $this->connection_ID);
		}
	}
?>