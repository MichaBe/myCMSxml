<?php
	/* Theme-Style-CMS-Conenctor. Entwickelt für die Verbindung zwischen 3rd-Party-Styles und dem CMS (Datenbank, Dokumente u. Bildern) */
	/* Highlevel-API, die fertiges HTML zurückliefert */
	
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
		
		//Liefert den Titel als <h1>-Tag zurück
		public function getHeader() {
			$query = "SELECT *
				FROM Konfiguration
				WHERE KID = 2";
			$result = mysql_query($query, $this->connection_ID);
			$i = 0;
			$assocResult = array();
			while($row = mysql_fetch_assoc($result)){
				$assocResult[$i] = $row;
				$i++;
			}
			return '<h1 class="titel">'.$assocResult[0]['Kvalue'].'</h1>';
		}
		
		//Liefert die Kategorien als <li>-Tags zurück
		//Die gerade aktive Kategorie bekommt die id "ActiveKategorie"
		//(Nur) Die restlichen Kategorien bekommen die id "Kategorie"
		public function getKategorien() {
			$query = "SELECT CID, Cname
				FROM Kategorie
				WHERE CID >= 4
				ORDER BY CID ASC";
			$result = mysql_query($query);
			$i = 0;
			$resultarray = array();
			$returner = "";
			while($row = mysql_fetch_assoc($result)){
				$resultarray[$i] = $row;
				$i++;
			}
			if(isset($_GET['CID'])) {
				foreach($resultarray as $curLine){
					if($_GET['CID'] == $curLine['CID'])
						$returner = $returner.'<li id="ActiveKategorie"><a href="index.php?CID='.$curLine['CID'].'">'.$curLine['Cname'].'</a></li>';
					else 
						$returner = $returner.'<li id="Kategorie"><a href="index.php?CID='.$curLine['CID'].'">'.$curLine['Cname'].'</a></li>';
				}
			}
			else {
				foreach($resultarray as $curLine){
					$returner = $returner.'<li id="Kategorie"><a href="index.php?CID='.$curLine['CID'].'">'.$curLine['Cname'].'</a></li>';
				}
			}
			return $returner;
		}
		
		//Liefert die Beiträge als Array an <div>-Tags zurück
		//Der erste <div>-Tag beinhaltet den Neuesten Beitrag
		//Es werden nur die Beiträge geladen, die für die aktive Kategorie
		//benötigt werden. Aufbau eines Beitrags:
		//<div class="snippet" id="[Kategorie des snippets]">
		//	<h2>[Überschrift des snippets]</h2>
		//	<h3>Veröffentlicht am [veröffentlichungsdatum] von [Author], letzte Änderung am [Änderungsdatum]<h3>
		//	<a href=...>[Der Beschreibungstext des snippets]</a>
		//</div>
		public function getBeitraege() {
			$hilfsquery = "SELECT *
				FROM Konfiguration
				WHERE Kname = 'nosnippet'";
			$result = mysql_query($hilfsquery);
			$i = 0;
			$resultarray = array();
			while($row = mysql_fetch_assoc($result)){
				$resultarray[$i] = $row;
				$i++;
			}
			$noSnippet = '<h2>'.$resultarray[0]['Kvalue'].'</h2>';
			
			$query;
			$returner = array();
			if(isset($_GET['CID']) && $_GET['CID'] != 4) {
				$query = sprintf("SELECT Beitrag.CID, Sheadline, Sreleased, Cname, Slastmod, SID, Sshorttext, Uname
					FROM Beitrag, Kategorie, Benutzer
					WHERE Beitrag.CID = Kategorie.CID
					AND Beitrag.UID = Benutzer.UID
					AND Beitrag.CID != 1
					AND Beitrag.CID != 2
					AND Beitrag.CID != 3
					AND Beitrag.CID != 4
					AND Beitrag.CID = %d",
					mysql_real_escape_string($_GET['CID']));
			}
			else {
				$query = "SELECT Beitrag.CID, Sheadline, Sreleased, Slastmod, SID, Sshorttext, Uname
					FROM Beitrag, Kategorie, Benutzer
					WHERE Beitrag.CID = Kategorie.CID
					AND Beitrag.UID = Benutzer.UID
					AND Beitrag.CID != 1
					AND Beitrag.CID != 2
					AND Beitrag.CID != 3
					AND Beitrag.CID != 4";
			}
			$result = mysql_query($query);
			$i = 0;
			$resultarray = array();
			while($row = mysql_fetch_assoc($result)){
				$resultarray[$i] = $row;
				$i++;
			}
			if(!(isset($resultarray[0]['SID'])))
				$returner[0] = $noSnippet;
			else {
				$j = 0;
				foreach($resultarray as $oneSnippet) {
					$oneTempLine = '<div class="snippet" id="'.$oneSnippet['CID'].'">
						<h2>'.$oneSnippet['Sheadline'].'</h2>
						<h3>Ver&#246;ffentlicht am '.$oneSnippet['Sreleased'].' von '.$oneSnippet['Uname'].', letzte &#196;nderung am '.$oneSnippet['Slastmod'].'</h3>
						<a href="snippet.php?SID='.$oneSnippet['SID'].'">'.$oneSnippet['Sshorttext'].'</a>
						</div>';
					$returner[$j] = $oneTempLine;
					$j++;
				}
			}
			return $returner;
		}
		
		//Liefert einen Beitrag als <div>-Tag zurück
		//<div class="snippet" id="[Kategorie des snippets]">
		//	<h2>[Überschrift des snippets]</h2>
		//	<h3>Veröffentlicht am [veröffentlichungsdatum] von [Author], letzte Änderung am [Änderungsdatum]<h3>
		//	[Text des Beitrags]
		//</div>
		//Im Fehlerfall wird eine Fehlermeldung als <h2>-Tag zurückgegeben
		public function getOneBeitrag() {
			$returner = "";
			if(isset($_GET['SID'])) {
				$query = sprintf("SELECT Sheadline, Sreleased, Slastmod, SID, Stext, Uname, CID
					FROM Beitrag, Benutzer
					WHERE Beitrag.UID = Benutzer.UID
					AND Beitrag.CID != 3
					AND Beitrag.CID != 4
					AND Beitrag.SID = %d", 
					$_GET['SID']);
				$result = mysql_query($query);
				$i = 0;
				$resultarray = array();
				while($row = mysql_fetch_assoc($result)){
					$resultarray[$i] = $row;
					$i++;
				}
				$returner = '<div class="snipppet" id="'.$resultarray[0]['CID'].'">
					<h2>'.$resultarray[0]['Sheadline'].'</h2>
					<h3>Ver&#246;ffentlicht am '.$resultarray[0]['Sreleased'].' von '.$resultarray[0]['Uname'].', letzte &#196;nderung am '.$resultarray[0]['Slastmod'].'</h3>
					'.$resultarray[0]['Stext'].'
					</div>';
			}
			return $returner;
		}
		
		//Liefert die Beiträge, die im Footer gepostet wurden, als <li>-Tags mit den Links zurück
		//Ist einer der Beiträge aktiv, bekommt dieser die id "ActiveinFooter"
		//(Nur) Die restlichen Beiträge bekommen die id "inFooter"
		public function getFooter() {
			$query = "SELECT SID, Sheadline 
				FROM Beitrag 
				WHERE CID = 1";
			$result = mysql_query($query, $this->connection_ID);
			$i = 0;
			$resultarray = array();
			$returner = "";
			while($row = mysql_fetch_assoc($result)){
				$resultarray[$i] = $row;
				$i++;
			}
			if(isset($_GET['SID'])) {
				foreach($resultarray as $curFoot) {
					if($_GET['SID'] == $curFoot['SID'])
						$returner = $returner.'<li id="ActiveinFooter"><a href="snippet.php?SID='.$curFoot['SID'].'">'.$curFoot['Sheadline'].'</a></li>';
					else
						$returner = $returner.'<li id="inFooter"><a href="snippet.php?SID='.$curFoot['SID'].'">'.$curFoot['Sheadline'].'</a></li>';
				}
			}
			else {
				foreach($resultarray as $curFoot) {
					$returner = $returner.'<li id="inFooter"><a href="snippet.php?SID='.$curFoot['SID'].'">'.$curFoot['Sheadline'].'</a></li>';
				}
			}
			return $returner;
		}
	}
?>