<?php
//Advanced FTP-Connector. Nur für die Benutzung in Verbindung mit dem Backend des CMS

	$globalConfig = include('config.php');
	
	class advanced_ftpconnector {
		private $connection_ID;
		private $globalConfig;
		
		public function __construct() {
			$this->globalConfig = $GLOBALS["globalConfig"];				
			$this->connection_ID = ftp_connect($this->globalConfig['ftp_server']);
			
			if($this->connection_ID != FALSE) {
				ftp_login($this->connection_ID, $this->globalConfig['ftp_user'], $this->globalConfig['ftp_passwd']);
			}
			else {
				return FALSE;
			}
		}
		public function __desctruct() {
			ftp_close($this->connection_ID);
		}
		
		public function uploadPic($oldname, $newname) {
			move_uploaded_file($_FILES[$oldname]['tmp_name'], $newname);
			
			//ftp_put($this->connection_ID, $_FILES[$newname]['tmp_name'], $source, FTP_BINARY);
			//move_uploaded_file($_FILES[$sourcepath]['tmp_name'], 'cms/backend/bilder/'.$newname);
		}
	}
?>