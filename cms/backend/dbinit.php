<?php
	function dbinit($conectID, $dbtoUse, $HELP){
		$querys = array(
			sprintf("USE %s",mysql_real_escape_string($dbtoUse)),
			"CREATE TABLE Rolle (
			RID SMALLINT NOT NULL AUTO_INCREMENT,
			Rtopic CHAR(25) NOT NULL,
			PRIMARY KEY(RID))",
			
			"CREATE TABLE Berechtigung (
			XID SMALLINT NOT NULL AUTO_INCREMENT,
			UID SMALLINT,
			RID SMALLINT,
			Xvalue CHAR(25),
			PRIMARY KEY(XID))",
			
			"CREATE TABLE Benutzer (
			UID SMALLINT NOT NULL AUTO_INCREMENT,
			Uname CHAR(25),
			Upassw CHAR(32),
			PRIMARY KEY(UID))",
			
			"CREATE TABLE Beitrag (
			SID INT NOT NULL AUTO_INCREMENT,
			UID SMALLINT,
			CID SMALLINT,
			Sheadline CHAR(40),
			Sshorttext TEXT,
			Stext TEXT,
			Slastmod DATE,
			Sreleased DATE,
			Skeywords CHAR(50),
			PRIMARY KEY(SID))",
			
			"CREATE TABLE Kategorie (
			CID SMALLINT NOT NULL AUTO_INCREMENT,
			Cshorttext TEXT,
			Cname CHAR(25),
			Ckeywords CHAR(50),
			PRIMARY KEY(CID))",
			
			"CREATE TABLE Ereignis (
			EID INT NOT NULL AUTO_INCREMENT,
			Etime DATE,
			Etext CHAR(60),
			PRIMARY KEY(EID))",
			
			"CREATE TABLE Hilfebeitrag (
			HSID SMALLINT NOT NULL AUTO_INCREMENT,
			HCID SMALLINT,
			HSheadline CHAR(40),
			HStext TEXT,
			PRIMARY KEY(HSID))",
			
			"CREATE TABLE Hilfekategorie (
			HCID SMALLINT NOT NULL AUTO_INCREMENT,
			HCname CHAR(25),
			PRIMARY KEY(HCID))",
			
			"CREATE TABLE Konfiguration (
			ConfigID SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			StyleName CHAR(15),
			PageTitle CHAR(15),
			CMSversion CHAR(10),
			CMSlanguage CHAR(15))",
			
			
			"ALTER TABLE Berechtigung
			ADD CONSTRAINT XUID
			FOREIGN KEY (UID)
			REFERENCES Benutzer(UID)",
			
			"ALTER TABLE Berechtigung
			ADD CONSTRAINT XRID
			FOREIGN KEY (RID)
			REFERENCES Rolle(RID)",
			
			"ALTER TABLE Beitrag
			ADD CONSTRAINT SUID
			FOREIGN KEY (UID)
			REFERENCES Benutzer(UID)",
			
			"ALTER TABLE Beitrag
			ADD CONSTRAINT SCID
			FOREIGN KEY (CID)
			REFERENCES Kategorie(CID)",
			
			"ALTER TABLE Hilfebeitrag
			ADD CONSTRAINT HSHCID
			FOREIGN KEY (HCID)
			REFERENCES Hilfekategorie(HCID)",
			
			
			"INSERT INTO Kategorie VALUES(1, NULL, 'FOOTER', NULL)",
			"INSERT INTO Kategorie VALUES(2, NULL, 'HIDDEN', NULL)",
			"INSERT INTO Kategorie VALUES(3, NULL, 'DRAFT', NULL)",
			"INSERT INTO Kategorie VALUES(4, NULL, 'Startseite', NULL)",
			
			"INSERT INTO Rolle VALUES(1, 'Hilfe')",
			"INSERT INTO Rolle VALUES(2, 'Ereignis')",
			"INSERT INTO Rolle VALUES(3, 'Beitrag')",
			"INSERT INTO Rolle VALUES(4, 'Kategorie')",
			"INSERT INTO Rolle VALUES(5, 'Benutzer')",
			"INSERT INTO Rolle VALUES(6, 'Allgemeine Einstellungen')",
			
			"INSERT INTO Konfiguration VALUES(1, 'konservativ', 'myCMS.xml', NULL, 'deutsch')",
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