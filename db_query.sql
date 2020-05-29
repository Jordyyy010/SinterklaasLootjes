USE lootjes_lootjes;

DROP TABLE IF EXISTS DeelnemerDetails;
DROP TABLE IF EXISTS Groep;
DROP TABLE IF EXISTS Deelnemers;
DROP TABLE IF EXISTS Oprichter;
DROP TABLE IF EXISTS Gebruikers;

CREATE TABLE Gebruikers (
    `GebruikerId` INT NOT NULL AUTO_INCREMENT,
    `GebruikersNaam` TINYTEXT NOT NULL,
    `Email` TINYTEXT NOT NULL,
    `Wachtwoord` LONGTEXT NOT NULL,
    PRIMARY KEY (GebruikerId)
);

CREATE TABLE Groep (
    `GroepId` INT NOT NULL AUTO_INCREMENT,
    `GroepsNaam` TINYTEXT NOT NULL,
    `Bedrag` INT NULL,
    `DatumViering` DATE NOT NULL,
    `DatumTrekking` INT(3) NOT NULL,
    `Postcode` TINYTEXT NOT NULL,
    `Compleet` TINYTEXT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (GroepId)
);

CREATE TABLE Deelnemers (
    `DeelnemerId` INT NOT NULL AUTO_INCREMENT,
    `DeelnemersNaam` TINYTEXT NOT NULL,
    `Email` TINYTEXT NULL,
    `Telefoonnummer` INT(15) NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (DeelnemerId)
);

CREATE TABLE Beheerder (
    `BeheerderId` INT NOT NULL AUTO_INCREMENT,
    `BeheerdersNaam` TINYTEXT NOT NULL,
    `Email` TINYTEXT NULL,
    `Bericht` TINYTEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (BeheerderId)
);

CREATE TABLE DeelnemerDetails (
    `DetailsId` INT NOT NULL AUTO_INCREMENT,
    `DeelnemerId` INT NULL,
    `BeheerderId` INT NULL,
    `GroepId` INT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (DetailsId),
    FOREIGN KEY (DeelnemerId) REFERENCES Deelnemers(DeelnemerId),
    FOREIGN KEY (BeheerderId) REFERENCES Beheerder(BeheerderId),
    FOREIGN KEY (GroepId) REFERENCES Groep(GroepId)
);
