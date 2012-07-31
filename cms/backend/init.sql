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
	Uchangepw BOOLEAN,
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
	Cname CHAR(30),
	Ckeywords CHAR(60),
	Ctarget CHAR(30),
	PRIMARY KEY(CID)
);

CREATE TABLE Bildgruppe (
	BGID INT NOT NULL AUTO_INCREMENT,
	CID INT,
	BGname CHAR(30),
	BGthumb INT,
	PRIMARY KEY(BGID)
);

CREATE TABLE Bild (
	BID INT NOT NULL AUTO_INCREMENT,
	BGID INT,
	Btitle CHAR(30),
	Bdescription TEXT,
	PRIMARY KEY(BID)
);
			
CREATE TABLE Ereignis (
	EID INT NOT NULL AUTO_INCREMENT,
	Etime DATE,
	Etext TEXT,
	PRIMARY KEY(EID)
);

CREATE TABLE Konfiguration(
  KID INT NOT NULL AUTO_INCREMENT,
  Kname CHAR(20),
  Kvalue TEXT,
  PRIMARY KEY(KID)
);

CREATE TABLE MOTD (
	MID INT NOT NULL AUTO_INCREMENT,
	Mtype ENUM('CMS', 'STYLE'),
	Mmessage TEXT,
	PRIMARY KEY(MID)
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

ALTER TABLE Bildgruppe
	ADD CONSTRAINT BGCID
		FOREIGN KEY (CID)
		REFERENCES Kategorie(CID);

ALTER TABLE Bildgruppe
	ADD CONSTRAINT BGBID
		FOREIGN KEY (BGthumb)
		REFERENCES Bild(BID);

ALTER TABLE Bild
	ADD CONSTRAINT BBGID
		FOREIGN KEY (BGID)
		REFERENCES Bildgruppe(BGID);

INSERT INTO Benutzer VALUES(1, 'Administrator', '8a974b0407e3f2f3bd9e1aa995563a7c', TRUE);
INSERT INTO Benutzer VALUES(2, 'Anonymous', 'd7a851cca17e12678069be57985832cc', TRUE);

			
INSERT INTO Kategorie VALUES(1, NULL, 'Footer', NULL, 'index');
INSERT INTO Kategorie VALUES(2, NULL, 'Versteckt', NULL, 'index');
INSERT INTO Kategorie VALUES(3, NULL, 'Entwurf', NULL, 'index');
INSERT INTO Kategorie VALUES(4, NULL, 'Startseite', NULL, 'index');


INSERT INTO Rolle VALUES(1, 'Am System anmelden', 'anmelden');
INSERT INTO Rolle VALUES(2, 'Beitr&#228;ge verwalten', 'beitraege');
INSERT INTO Rolle VALUES(3, 'Kategorien verwalten', 'kategorien');
INSERT INTO Rolle VALUES(4, 'Benutzer und Berechtigungen verwalten', 'benutzer');
INSERT INTO Rolle VALUES(5, 'Allgemeine Konfiguration &#228;ndern', 'konfiguration');
INSERT INTO Rolle VALUES(6, 'Ereignislog einsehen', 'ereignisse');
INSERT INTO Rolle VALUES(7, 'Galerien verwalten', 'galerien');


INSERT INTO Berechtigung VALUES(NULL, 1, 1, TRUE);
INSERT INTO Berechtigung VALUES(NULL, 1, 2, TRUE);
INSERT INTO Berechtigung VALUES(NULL, 1, 3, TRUE);
INSERT INTO Berechtigung VALUES(NULL, 1, 4, TRUE);
INSERT INTO Berechtigung VALUES(NULL, 1, 5, TRUE);
INSERT INTO Berechtigung VALUES(NULL, 1, 6, TRUE);
INSERT INTO Berechtigung VALUES(NULL, 1, 7, TRUE);

INSERT INTO Berechtigung VALUES(NULL, 2, 1, FALSE);
INSERT INTO Berechtigung VALUES(NULL, 2, 2, FALSE);
INSERT INTO Berechtigung VALUES(NULL, 2, 3, FALSE);
INSERT INTO Berechtigung VALUES(NULL, 2, 4, FALSE);
INSERT INTO Berechtigung VALUES(NULL, 2, 5, FALSE);
INSERT INTO Berechtigung VALUES(NULL, 2, 6, FALSE);
INSERT INTO Berechtigung VALUES(NULL, 2, 7, FALSE);


INSERT INTO Konfiguration VALUES(1, 'style', 'konservativ');
INSERT INTO Konfiguration VALUES(2, 'title', 'myCMS.xml');
INSERT INTO Konfiguration VALUES(3, 'nosnippet', 'Hier wurde noch kein Beitrag ver&#246;ffentlicht');
INSERT INTO Konfiguration VALUES(4, 'version', '0.1.0');

INSERT INTO Beitrag VALUES(1, 1, 1, 'myCMSxml', NULL, '<p align="center"><form action="cms/management/login.php" method="post"><table><tr><td>Benutzername:</td><td><input type="text" name="username"/></td></tr><tr><td>Passwort:</td><td><input type="password" name="passwort"/></td></tr></table><input type="submit" value="Anmelden"/></form></p>', '2012-05-20', '2012-05-20', NULL);
INSERT INTO Beitrag VALUES(2, 1, 2, 'Error 404', NULL, '<h1>Die von Ihnen gesuchte Seite konnte leider nicht gefunden werden</h1>Wir bitten, dies zu entschuldigen.', '2012-05-20', '2012-05-20', NULL);


INSERT INTO Ereignis VALUES(NULL, CURDATE(), 'Administrator installiert myCMSxml');