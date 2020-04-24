DROP DATABASE IF EXISTS lootjes;

CREATE DATABASE lootjes;

USE lootjes;

CREATE TABLE Groep (
    `GroepId` INT NOT NULL AUTO_INCREMENT,
    `GroepsNaam` VARCHAR(255) NOT NULL,
    `Bedrag` INT NULL,
    `Datum` DATE NULL,
    PRIMARY KEY (GroepId)
);

CREATE TABLE Deelnemers (
    `DeelnemerId` INT NOT NULL AUTO_INCREMENT,
    `DeelnemersNaam` VARCHAR(255),
    `Email` VARCHAR(50),
    `Postcode` VARCHAR(6),
    `Telefoonnummer` VARCHAR(15),
    PRIMARY KEY (DeelnemerId)
);

CREATE TABLE Oprichter (
    `OprichterId` INT NOT NULL AUTO_INCREMENT,
    `OprichtersNaam` VARCHAR(255) NOT NULL,
    `Email` VARCHAR(255) NULL,
    `Bericht` VARCHAR(255),
    PRIMARY KEY (OprichterId)
);

CREATE TABLE DeelnemerDetails (
    `DetailsId` INT NOT NULL AUTO_INCREMENT,
    `DeelnemerId` INT NULL,
    `OprichterId` INT NULL,
    `GroepId` INT NOT NULL,
    PRIMARY KEY (DetailsId),
    FOREIGN KEY (DeelnemerId) REFERENCES Deelnemers(DeelnemerId),
    FOREIGN KEY (OprichterId) REFERENCES Oprichter(OprichterId),
    FOREIGN KEY (GroepId) REFERENCES Groep(GroepId)
);

-- Groep Data
-- INSERT INTO Groep (GroepsNaam, Bedrag, Datum)
-- VALUES ('Gekte', '100.00', '2020-12-05');
-- INSERT INTO Groep (GroepsNaam, Bedrag, Datum)
-- VALUES ('EWA', '50.00', '2020-12-05');
-- INSERT INTO Groep (GroepsNaam, Bedrag, Datum)
-- VALUES ('G E Z E L L I E', '25.00', '2020-12-05');

-- Deelnemers Data
-- INSERT INTO Deelnemers (DeelnemersNaam, Email, Postcode, Telefoonnummer)
-- VALUES ('Celine', 'celinerijerink@gmail.com', '3319HD', '0629473510');
-- INSERT INTO Deelnemers (DeelnemersNaam, Email, Postcode, Telefoonnummer)
-- VALUES ('Nick', 'nickvanderklooster@gmail.com', '3312KD', '0647295025');
-- INSERT INTO Deelnemers (DeelnemersNaam, Email, Postcode, Telefoonnummer)
-- VALUES ('Jarno', 'jarnomiddel@gmail.com', '3317NW', '0634509812');
-- INSERT INTO Deelnemers (DeelnemersNaam, Email, Postcode, Telefoonnummer)
-- VALUES ('Adriaan', 'adriaanmiddel@gmail.com', '3317NW', '0609128734');


-- Oprichter Data
-- INSERT INTO Oprichter (OprichtersNaam, Email, Bericht)
-- VALUES ('Damaris', 'damarismiddel@hotmail.nl', 'Hey hey, Zullen we met de familie lootjes trekken voor tijdens sinterklaas? Als je het leuk vindt klik dan op de knop hieronder!');
-- INSERT INTO Oprichter (OprichtersNaam, Email, Bericht)
-- VALUES ('Bianca', 'biancamiddel@hotmail.nl', 'Hoi, Zullen we met de familie lootjes trekken voor tijdens sinterklaas? Als je het leuk vindt klik dan op de knop hieronder!');
-- INSERT INTO Oprichter (OprichtersNaam, Email, Bericht)
-- VALUES ('Jordy', 'jordyclement@hotmail.nl', 'EWAAAA, Zullen we met de familie lootjes trekken voor tijdens sinterklaas? Als je het leuk vindt klik dan op de knop hieronder!');


-- DeelnemerDetails Data
-- INSERT INTO DeelnemerDetails (DeelnemerId, OprichterId, GroepId)
-- VALUES ('1', '3', '2');
-- INSERT INTO DeelnemerDetails (DeelnemerId, OprichterId, GroepId)
-- VALUES ('2', '3', '2');
-- INSERT INTO DeelnemerDetails (DeelnemerId, OprichterId, GroepId)
-- VALUES ('1', '1', '1');
-- INSERT INTO DeelnemerDetails (DeelnemerId, OprichterId, GroepId)
-- VALUES ('2', '1', '1');
-- INSERT INTO DeelnemerDetails (DeelnemerId, OprichterId, GroepId)
-- VALUES ('3', '2', '3');
-- INSERT INTO DeelnemerDetails (DeelnemerId, OprichterId, GroepId)
-- VALUES ('4', '2', '3');