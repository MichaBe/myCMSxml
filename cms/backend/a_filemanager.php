<?php
//Advanced Filemanager. Bietet sämtliche Funktionen für die Verbindung mit den Dateien (FTP)
//Sowie für die Verwaltung dieser über die Datenbank (SQL) an

	$globalConfig = include('config.php');
	
	class advanced_filemanager {
		private $DBconnection;
		private $FTPconnection;
		private $globalConfig;
		
		public function __construct() {
			$this->globalConfig = $GLOBALS["globalConfig"];
			$this->DBconnection = $this->connection_ID = mysql_connect($this->globalConfig["db_server"], $this->globalConfig["db_user"], $this->globalConfig["db_passwd"]);
			
			if($this->connection_ID != FALSE) {
				mysql_query(sprintf("USE %s", mysql_real_escape_string($this->globalConfig["db_scheme"])), $this->connection_ID);
			}
			else {
				return FALSE;
			}
			
			$this->FTPconnection = ftp_connect($this->globalConfig["ftp_server"]);
			$tmpLogin = ftp_login($this->FTPconnection, $this->globalConfig["ftp_user"], $this->globalConfig["ftp_passwd"]);
			
			if($this->FTPconnection && $tmpLogin) {
				ftp_chdir($this->FTPconnection, "/cms/dateien/");
				return TRUE;
			}
			else {
				return FALSE;
			}
		}
		public function __destruct() {
			ftp_close($this->FTPconnection);
			mysql_close($this->DBconnection);
			return TRUE;
		}
		
		public function upload($localPath, $property) {
			$query = "INSERT INTO Datei VALUES(NULL, NULL, NULL)";
			mysql_query($query);
			$newID = mysql_insert_id();
			$splitted = explode(".", $localPath);
			$newFileName = $newID.'.'.$splitted[count($splitted)-1];
			$uplResult = ftp_put($this->FTPconnection, $newFileName, $localPath, FTP_BINARY);
			
			$query = sprintf("UPDATE Datei
				SET Fname = '%s',
				Ftype = '%s'
				WHERE FID = %d",
				mysql_real_escape_string($property['Ftype']),
				mysql_real_escape_string($property['Fname']),
				$newID);
			$result = mysql_query($query);
			return $result;
		}
	}
?>