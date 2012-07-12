CREATE TABLE Rolle (
	RID INT NOT NULL AUTO_INCREMENT,
	Rtopic CHAR(40),
	Rshort CHAR(20),
	PRIMARY KEY(RID)
);
			
CREATE TABLE Berechtigung (
	XID INT NOT NULL AUTO_INCREMENT,
	UID INT,
	RID INT,
	Xvalue BOOLEAN,
	PRIMARY KEY(XID)
);
			
CREATE TABLE Benutzer (
	UID INT NOT NULL AUTO_INCREMENT,
	Uname CHAR(20),
	Upassw CHAR(40),
	PRIMARY KEY(UID)
);
			
CREATE TABLE Beitrag (
	SID INT NOT NULL AUTO_INCREMENT,
	UID INT,
	CID INT,
	Sheadline CHAR(30),
	Sshorttext TEXT,
	Stext TEXT,
	Slastmod DATE,
	Sreleased DATE,
	Skeywords CHAR(60),
	PRIMARY KEY(SID)
);
			
CREATE TABLE Kategorie (
	CID INT NOT NULL AUTO_INCREMENT,
	Cshorttext TEXT,
	Cname CHAR(20),
	Ckeywords CHAR(60),
	PRIMARY KEY(CID)
);
			
CREATE TABLE Ereignis (
	EID INT NOT NULL AUTO_INCREMENT,
	Etime DATE,
	Etext TEXT,
	PRIMARY KEY(EID)
);

CREATE TABLE Konfiguration (
	KID INT NOT NULL AUTO_INCREMENT,
	Kstyle CHAR(20),
	Ktitle CHAR(20),
	Kversion CHAR(10),
	Klanguage CHAR(20),
	Knosnippet TEXT,
	PRIMARY KEY(KID)
);
			
			
ALTER TABLE Berechtigung
	ADD CONSTRAINT XUID
		FOREIGN KEY (UID)
		REFERENCES Benutzer(UID);
			
ALTER TABLE Berechtigung
	ADD CONSTRAINT XRID
		FOREIGN KEY (RID)
		REFERENCES Rolle(RID);
			
ALTER TABLE Beitrag
	ADD CONSTRAINT SUID
		FOREIGN KEY (UID)
		REFERENCES Benutzer(UID);
			
ALTER TABLE Beitrag
	ADD CONSTRAINT SCID
		FOREIGN KEY (CID)
		REFERENCES Kategorie(CID);


INSERT INTO Benutzer VALUES(1, 'Administrator', '8a974b0407e3f2f3bd9e1aa995563a7c');
INSERT INTO Benutzer VALUES(2, 'Anonymous', 'd7a851cca17e12678069be57985832cc');

			
INSERT INTO Kategorie VALUES(1, NULL, 'FOOTER', NULL);
INSERT INTO Kategorie VALUES(2, NULL, 'HIDDEN', NULL);
INSERT INTO Kategorie VALUES(3, NULL, 'DRAFT', NULL);
INSERT INTO Kategorie VALUES(4, NULL, 'Startseite', NULL);


INSERT INTO Rolle VALUES(1, 'Am System anmelden', 'anmelden');
INSERT INTO Rolle VALUES(2, 'Beitr&#228;ge verwalten', 'beitraege');
INSERT INTO Rolle VALUES(3, 'Kategorien verwalten', 'kategorien');
INSERT INTO Rolle VALUES(4, 'Benutzer und Berechtigungen verwalten', 'benutzer');
INSERT INTO Rolle VALUES(5, 'Allgemeine Konfiguration &#228;ndern', 'konfiguration');
INSERT INTO Rolle VALUES(6, 'Ereignislog einsehen', 'ereignisse');


INSERT INTO Berechtigung VALUES(NULL, 1, 1, TRUE);
INSERT INTO Berechtigung VALUES(NULL, 1, 2, TRUE);
INSERT INTO Berechtigung VALUES(NULL, 1, 3, TRUE);
INSERT INTO Berechtigung VALUES(NULL, 1, 4, TRUE);
INSERT INTO Berechtigung VALUES(NULL, 1, 5, TRUE);
INSERT INTO Berechtigung VALUES(NULL, 1, 6, TRUE);

INSERT INTO Berechtigung VALUES(NULL, 2, 1, FALSE);
INSERT INTO Berechtigung VALUES(NULL, 2, 2, FALSE);
INSERT INTO Berechtigung VALUES(NULL, 2, 3, FALSE);
INSERT INTO Berechtigung VALUES(NULL, 2, 4, FALSE);
INSERT INTO Berechtigung VALUES(NULL, 2, 5, FALSE);
INSERT INTO Berechtigung VALUES(NULL, 2, 6, FALSE);


INSERT INTO Konfiguration VALUES(1, 'konservativ', 'myCMS.xml', '0.0.4', 'deutsch', 'Hier wurde noch kein Beitrag ver&#246;ffentlicht');


INSERT INTO Beitrag VALUES(1, 1, 1, 'myCMSxml', NULL, '<p align="center"><form action="cms/management/login.php" method="post"><table><tr><td>Benutzername:</td><td><input type="text" name="username"/></td></tr><tr><td>Passwort:</td><td><input type="password" name="passwort"/></td></tr></table><input type="submit" value="Anmelden"/></form></p>', '2012-05-20', '2012-05-20', NULL);
INSERT INTO Beitrag VALUES(2, 1, 2, 'Error 404', NULL, '<h1>Die von Ihnen gesuchte Seite konnte leider nicht gefunden werden</h1>Wir bitten, dies zu entschuldigen.', '2012-05-20', '2012-05-20', NULL);


INSERT INTO Ereignis VALUES(NULL, CURDATE(), 'Administrator installiert myCMSxml');