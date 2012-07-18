myCMSxml - Ein php-Projekt
==========================

__Aktuelle Version: 0.0.8, Lizenz: CC BY 3.0__
----------------------------------------------

# Ein kleiner Rückblick #
myCMSxml ist ein kleines Projekt, das ich vor ca. 4 Monaten (Anfang 2012) begonnen hatte,
um mir selbst php beizubringen. In den ersten Versionen bassierte dieses 'CMS', wie man es da
allerdings noch nicht nennen konnte, auf xml. Damit waren auch viele Schwächen verbunden. Das 
klassischste Beispiel dafür: Was passiert, wenn ein Author von Beiträgen seinen Namen ändert? 
Wie übernehme ich diese Änderung am besten in Alle Beiträge, die ja als xml-Datei abgespeichert waren?

# Gegenwart #
Mittlerweile ist das gesamte CMS auf MySQL umgestellt. Das Frontend ist komplett fertig gestellt 
und das Backend benötigt nur noch den nötigen Feinschliff (siehe ToDo-Listen)

## Installation ##

__Wichtiger Hinweis: Das CMS befindet sich noch im pre-Alpha-Stadium. Für etwaige Schäden bei einer 
installation werde ich nicht aufkommen!__

Für die installation des CMS wird der Zugriff auf das entsprechende php-Rootverzeichnis benötigt (via FTP / Browserinterface / ... ). 
Außerdem muss das Datenbank-Initscript auf dem Server ausgeführt werden. Hierfür bieten die meisten 
Provider eine Administrationsoberfläche wie z. B. phpmyAdmin an. Folgende Schritte müssen für die 
Installation durchgeführt werden:

1. Bearbeiten der config.php
	Diese Datei liegt im Verzeichnis /cms/backend/ und enthält die für die Datenbankverbindung wichtigen 
	Einstellungen wie z. B. Servername, Datenbank-User, ... . Diese Angaben bekommen Sie von ihrem Provider.
2. Ausführen des SQL-Inizialisierungsscriptes
	Dieses Script liegt unter /cms/backend/init.sql und muss auf der Datenbank ausgeführt werden, die auch im 
	config-file angegeben wurde. Dies kann z. B. über eine Weboberfläche wie phpmyAdmin oder über die Kommandozeile 
	geschehen.
3. Hochladen der Dateien
	Als letzter Schritt müssen alle Dateien auf den Server hochgeladen werden. Fertig!

## Beispiel ##
Wer das ganze mal Live sehen will, kann sich den [Beispielblog](http://www.mycmsxml.org) ansehen und mir gerne Rückmeldung geben, 
was ihm gefällt, und wo noch was fehlt. Ich bin offen für neues, solange das Sinn macht ;)
### Update vom 16.7.2012 ###
Das Backend ist komplett fertiggestellt. In den ToDo-Listen stehen nun noch die Komponenten, die Verbesserungen benötigen.

# Zukunft #
Hier noch ein kleiner Überblick, was auf meiner derzeitigen ToDo-Liste steht:

### Bis Version 0.1.0 ###
* _Tipp des Tages_ in die CMS-Startseite einbauen
* *ERLEDIGT:* Anzahl der Beiträge pro Kategorie soll in der Kategorieübersicht angezeigt werden
* *ERLEDIGT:* Ändern des Designs für die Maske zum erstellen der Beiträge
* *ERLEDIGT:* Ändern des Designs zum Erstellen / Ändern von Kategorien
* *ERLEDIGT:* Ändern der Benutzerrechte direkt in der Übersicht ermöglichen
* Ermöglichen des Erstellens eigener Ereignisse im Log
* Sicherheit: Inizialisierungspasswörter _MÜSSEN_ geändert werden

### Bis Version 0.2.0 ###
* Ermöglichen von Inizialisierungsscripten für Themes
* Maske für das Hochladen von Themes
* Erstellen eines Theme-Database-Connector, über den Themes Änderungen in der Datenbank vornehmen können

### Bis Version 0.3.0 ###
* Ermöglichen von Benutzerdefinierten Head-Elementen (z. B. eigenen Tracking-Codes, ...)

### ... ###
* RSS / Atom - Feeds ermöglichen
* Screenshoots vom (fertigen Teil des) Backend / G+-Seite für myCMSxml / github-wiki / ??

Gerne nehm ich hier noch Ideen auf. An andere php-Entwickler: Gerne könnt ihr dieses Projekt forken. 
Allerdings wird das bei diesem Codedurcheinander nicht einfach. Ich verspreche Besserung. 
Für Bugmeldungen könnt ihr euch auch gerne an mich wenden.