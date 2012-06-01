INSERT INTO Kategorie VALUES (5, 'Die erste neue Kategorie', 'Erste Kategorie', 'erste,kategorie,neu');
INSERT INTO Kategorie VALUES (6, 'Die zweite Kategorie', 'Zweite Kategorie', NULL);
INSERT INTO Kategorie VALUES (7, 'Eine leere Kategorie', 'Leere Kategorie', 'leer, Kategorie, test');

INSERT INTO Beitrag VALUES (10, 1, 5, 'Beitrag in Kat. 5', 'Ein Beitrag f&#252;r die erste Kategorie', 'Der eigentliche Beitrag steht hier', '2000-01-01', '2000-01-01', NULL);
INSERT INTO Beitrag VALUES (11, 1, 6, 'Beitrag in Kat. 6', 'Ein Beitrag f&#252;r die zweite Kategorie', 'Dieser Beitrag wurde gleichzeitig mit dem ersten angelegt, allerdings nochmals modifiziert', '2000-01-02', '2000-01-01', 'Dies,ist,ein,Schl&#252;sselwort');
INSERT INTO Beitrag VALUES (12, 1, 6, 'Nochmal Kat. 6', 'Dies ist ein weiterer Beitrag f&#252;r Kategorie 6', 'Der eigentliche Beitrag', CURDATE(), CURDATE(), NULL);