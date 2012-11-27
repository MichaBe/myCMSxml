<?php
//Advanced DB-Connector. Nur für die Benutzung in Verbindung mit dem Backend des CMS

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
				ORDER BY UID DESC";
			$result = mysql_query($query, $this->connection_ID);
			$i = 0;
			$returnarray = array();
			while($row = mysql_fetch_assoc($result)){
				$returnarray[$i] = $row;
				$i++;
			}
			return $returnarray;
		}
		public function getOneBenutzerByNameOrID($Uname) {
			$query = sprintf("SELECT *
				FROM Benutzer
				WHERE Uname = '%s'
				OR UID = %d", 
				mysql_real_escape_string($Uname), 
				mysql_real_escape_string($Uname));
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
			$query = sprintf("SELECT Berechtigung.RID, Xvalue, Rtopic, Rshort
				FROM Rolle, Berechtigung, Benutzer
				WHERE Benutzer.UID = Berechtigung.UID
				AND Rolle.RID = Berechtigung.RID
				AND Benutzer.UID = %d
				ORDER BY Berechtigung.RID", 
				mysql_real_escape_string($UID));
			$result = mysql_query($query, $this->connection_ID);
			$i = 0;
			$returnarray = array();
			while($row = mysql_fetch_assoc($result)){
				$returnarray[$i] = $row;
				$i++;
			}
			return $returnarray;
		}
		public function getAllPossibleRights() {
			$query = "SELECT *
				FROM Rolle
				ORDER BY RID ASC";
			$result = mysql_query($query);
			$i = 0;
			$returnarray = array();
			while($row = mysql_fetch_assoc($result)){
				$returnarray[$i] = $row;
				$i++;
			}
			return $returnarray;
		}
		
		public function getAllKategorien() {
			$query = "SELECT COUNT(Beitrag.SID) AS Scount, Kategorie.CID, Cname, Ckeywords 
				FROM Beitrag RIGHT JOIN Kategorie
				ON Kategorie.CID = Beitrag.CID
				GROUP BY Kategorie.CID
				ORDER BY CID DESC";
			$result = mysql_query($query, $this->connection_ID);
			$i = 0;
			$returnarray = array();
			while($row = mysql_fetch_assoc($result)){
				if($row['CID'] == 1 || $row['CID'] == 2) {
					$row['Scount'] -= 1;
				}
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
		
		public function getAllBeitraege() {
			$query = "SELECT SID, Uname, Cname, Sheadline, Slastmod, Sreleased
				FROM Benutzer, Beitrag, Kategorie
				WHERE Benutzer.UID = Beitrag.UID
				AND Kategorie.CID = Beitrag.CID
				AND SID != 1
				AND SID != 2
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
			$query = sprintf("SELECT SID, Cname, Beitrag.CID, Sheadline, Sshorttext, Stext, Skeywords
				FROM Beitrag, Kategorie
				WHERE Beitrag.CID = Kategorie.CID
				AND Beitrag.SID = %d", 
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
		
		public function getKonfiguration() {
			$query = "SELECT *
				FROM Konfiguration
				ORDER BY KID ASC";
			$result = mysql_query($query, $this->connection_ID);
			$i = 0;
			$returnarray = array();
			while($row = mysql_fetch_assoc($result)){
				$returnarray[$i] = $row;
				$i++;
			}
			return $returnarray;
		}
		
		public function changeOneBenutzer($UID, $RID, $Xvalue) {
			$query =  sprintf("UPDATE Berechtigung
				SET Xvalue = %d
				WHERE RID = %d
				AND UID = %d", 
				mysql_real_escape_string($Xvalue), 
				mysql_real_escape_string($RID), 
				mysql_real_escape_string($UID));
			
			mysql_query($query, $this->connection_ID);
		}
		public function changeOneBenutzerPassw($UID, $UpasswHASHED, $Uchangepw) {
			if($Uchangepw) {
			$query = sprintf("UPDATE Benutzer
				SET Upassw = '%s',
				Uchangepw = TRUE
				WHERE UID = %d",
				mysql_real_escape_string($UpasswHASHED),
				mysql_real_escape_string($UID));
			}
			else {
				$query = sprintf("UPDATE Benutzer
				SET Upassw = '%s',
				Uchangepw = FALSE
				WHERE UID = %d",
				mysql_real_escape_string($UpasswHASHED),
				mysql_real_escape_string($UID));
			}
			mysql_query($query, $this->connection_ID);
		}
		public function addOneBenutzer($Uname, $UpasswHASHED) {
			$query = sprintf("INSERT INTO Benutzer 
				VALUES(NULL, '%s', '%s', TRUE)", 
				mysql_real_escape_string($Uname), 
				mysql_real_escape_string($UpasswHASHED));
			mysql_query($query, $this->connection_ID);
			$UID = mysql_insert_id($this->connection_ID);
			
			$query = array();
			$allRights = $this->getAllPossibleRights();
			$i = 0;
			foreach($allRights as $curRight) {
				$query[$i] = sprintf("INSERT INTO Berechtigung
					VALUES(NULL, %d, %d, 0)", 
					mysql_real_escape_string($UID), 
					mysql_real_escape_string($curRight['RID']));
					$i++;
			}
			foreach($query as $curQuery) {
				mysql_query($curQuery, $this->connection_ID);
			}
			return $UID;
		}
		public function delOneBenutzer($UID) {
			$query[0] = sprintf("DELETE FROM Berechtigung
				WHERE UID = %d
				AND UID != 1
				AND UID != 2",
				mysql_real_escape_string($UID));
			$query[1] = sprintf("DELETE FROM Benutzer
				WHERE UID = %d
				AND UID != 1
				AND UID != 2",
				mysql_real_escape_string($UID));
			
			foreach($query as $curQuery) {
				mysql_query($curQuery, $this->connection_ID);
			}
		}
		
		public function changeOneKategorie($CID, $Kategorie) {
			$query = sprintf("UPDATE Kategorie
				SET Cshorttext = '%s',
				Cname = '%s',
				Ckeywords = '%s',
				Ctarget = '%s'
				WHERE CID = %d", 
				mysql_real_escape_string($Kategorie['Cshorttext']), 
				mysql_real_escape_string($Kategorie['Cname']), 
				mysql_real_escape_string($Kategorie['Ckeywords']),
				mysql_real_escape_string($Kategorie['Ctarget']),
				mysql_real_escape_string($CID));
			mysql_query($query, $this->connection_ID);
		}
		public function addOneKategorie($Kategorie) {
			$query = sprintf("INSERT INTO Kategorie
				VALUES(NULL, '%s', '%s', '%s', '%s')", 
				mysql_real_escape_string($Kategorie['Cshorttext']), 
				mysql_real_escape_string($Kategorie['Cname']), 
				mysql_real_escape_string($Kategorie['Ckeywords']),
				mysql_real_escape_string($Kategorie['Ctarget']));
			mysql_query($query, $this->connection_ID);
		}
		public function delOneKategorie($CID) {
			$query = sprintf("DELETE FROM Kategorie
				WHERE CID = %d
				AND CID != 1
				AND CID != 2
				AND CID != 3
				AND CID != 4", 
				mysql_real_escape_string($CID));
			mysql_query($query, $this->connection_ID);
		}
		
		public function changeOneGalerie($CID, $Galerie) {
			$this->changeOneKategorie($CID, $Galerie);
		}
		public function addOneGalerie($Galerie) {
			$this->addOneKategorie($Galerie);
		}
		public function delOneGalerie($CID) {
			$this->delOneKategorie($CID);
		}
		
		public function setThumbfromBG($BGID, $BGthumb=NULL) {
			if($BGthumb != NULL) {
			$query = sprintf("UPDATE Bildgruppe
				SET BGthumb = %d
				WHERE BGID = %d", 
				mysql_real_escape_string($BGthumb),
				mysql_real_escape_string($BGID));
			}
			else {
				$query = sprintf("UPDATE Bildgruppe
				SET BGthumb = NULL
				WHERE BGID = %d",
				mysql_real_escape_string($BGID));
			}
			mysql_query($query, $this->connection_ID);
		}
		public function changeOneBildgruppe($BGID, $Bildgruppe) {
			$query = sprintf("UPDATE Bildgruppe
				SET CID = %d,
				BGname = '%s'
				WHERE BGID = %d", 
				mysql_real_escape_string($Bildgruppe['CID']), 
				mysql_real_escape_string($Bildgruppe['BGname']), 
				mysql_real_escape_string($BGID));
			mysql_query($query, $this->connection_ID);
		}
		public function addOneBildgruppe($Bildgruppe) {
			$query = sprintf("INSERT INTO Bildgruppe
				VALUES(NULL, %d, '%s', NULL)",
				mysql_real_escape_string($Bildgruppe['CID']), 
				mysql_real_escape_string($Bildgruppe['BGname']));
			mysql_query($query, $this->connection_ID);
		}
		
		public function addOneBild($Bild) {
			$query = sprintf("INSERT INTO Bild
				VALUES(NULL, %d, '%s', '%s')",
				mysql_real_escape_string($Bild['BGID']),
				mysql_real_escape_string($Bild['Btitle']),
				mysql_real_escape_string($Bild['Bdescription']));
			mysql_query($query, $this->connection_ID);
			return mysql_insert_id();
		}
		public function delOneBild($BID) {
			$query = sprintf("DELETE FROM Bild
				WHERE BID = %d",
				mysql_real_escape_string($BID));
			mysql_query($query, $this->connection_ID);
		}
		
		public function changeOneBeitrag($SID, $Beitrag) {
			$query = sprintf("UPDATE Beitrag
				SET CID = %d,
				Sheadline = '%s',
				Sshorttext = '%s',
				Stext = '%s',
				Slastmod = CURDATE(),
				Skeywords = '%s'", 
				mysql_real_escape_string($Beitrag['CID']), 
				mysql_real_escape_string($Beitrag['Sheadline']), 
				mysql_real_escape_string($Beitrag['Sshorttext']), 
				mysql_real_escape_string($Beitrag['Stext']),
				mysql_real_escape_string($Beitrag['Skeywords']));
			if(isset($Beitrag['UID'])) {
				$query = $query.', UID = '.mysql_real_escape_string($Beitrag['UID']).' ';
			}
			if($Beitrag['Sreleased'] == TRUE)
				$query = sprintf("%s, 
					Sreleased = CURDATE()
					WHERE SID = %d",
					$query,
					mysql_real_escape_string($SID));
			else
				$query = sprintf("%s
					WHERE SID = %d",
					$query,
					mysql_real_escape_string($SID));
				
			mysql_query($query, $this->connection_ID);
		}
		public function addOneBeitrag($Beitrag) {
			$query = sprintf("INSERT INTO Beitrag
				VALUES(NULL, %d, %d, '%s', '%s', '%s', CURDATE(), CURDATE(), '%s')",
				mysql_real_escape_string($Beitrag['UID']), 
				mysql_real_escape_string($Beitrag['CID']), 
				mysql_real_escape_string($Beitrag['Sheadline']), 
				mysql_real_escape_string($Beitrag['Sshorttext']), 
				mysql_real_escape_string($Beitrag['Stext']), 
				mysql_real_escape_string($Beitrag['Skeywords']));
			mysql_query($query, $this->connection_ID);
		}
		public function delOneBeitrag($SID) {
			$query = sprintf("DELETE FROM Beitrag
				WHERE SID = %d
				AND SID != 1
				AND SID != 404", 
				mysql_real_escape_string($SID));
			mysql_query($query, $this->connection_ID);
		}
		public function movetoHIDDENfromOneKategorie($CID) {
			$query = sprintf("UPDATE Beitrag
				SET CID = 2
				WHERE CID = %d", 
				mysql_real_escape_string($CID));
			mysql_query($query, $this->connection_ID);
		}
		
		public function changeKonfiguration($Konfiguration) {
			$query = array();
			$query[0] = sprintf("UPDATE Konfiguration
				SET Kvalue = '%s'
				WHERE KID = 1",
				mysql_real_escape_string($Konfiguration['Kstyle']));
			$query[1] = sprintf("UPDATE Konfiguration
				SET Kvalue = '%s'
				WHERE KID = 2",
				mysql_real_escape_string($Konfiguration['Ktitle']));
			$query[2] = sprintf("UPDATE Konfiguration
				SET Kvalue = '%s'
				WHERE KID = 3",
				mysql_real_escape_string($Konfiguration['Knosnippet']));
			foreach($query as $curquery) {
				mysql_query($curquery, $this->connection_ID);
			}
			
		}

	}
?>