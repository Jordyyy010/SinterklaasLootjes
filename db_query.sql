DROP DATABASE IF EXISTS lootjes;
CREATE DATABASE lootjes;
USE lootjes;

DROP TABLE IF EXISTS Groep;
DROP TABLE IF EXISTS Deelnemers;
DROP TABLE IF EXISTS Beheerders;
DROP TABLE IF EXISTS Gebruikers;

CREATE TABLE Gebruikers (
    GebruikerID INT NOT NULL AUTO_INCREMENT,
    GebruikersNaam TINYTEXT NOT NULL,
    Email TINYTEXT NOT NULL,
    Wachtwoord LONGTEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (GebruikerID)
);

CREATE TABLE Groep (
    GroepID INT NOT NULL AUTO_INCREMENT,
    GroepsNaam TINYTEXT NOT NULL,
    Bedrag INT NULL,
    DatumViering DATE NOT NULL,
    DatumTrekking INT(3) NOT NULL,
    Postcode TINYTEXT NOT NULL,
    Compleet TINYTEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (GroepID)
);

CREATE TABLE Deelnemers (
    DeelnemerID INT NOT NULL AUTO_INCREMENT,
    DeelnemersNaam TINYTEXT NOT NULL,
    Email TINYTEXT NULL,
    Telefoonnummer INT(15) NULL,
    GroepID INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (DeelnemerID),
    FOREIGN KEY (GroepID) REFERENCES Groep (GroepID)
);

CREATE TABLE Beheerders (
    BeheerderID INT NOT NULL AUTO_INCREMENT,
    BeheerdersNaam TINYTEXT NOT NULL,
    Email TINYTEXT NULL,
    Bericht TINYTEXT,
    GroepID INT NULL,
    GebruikerID INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (BeheerderId),
    FOREIGN KEY (GroepID) REFERENCES Groep (GroepID),
    FOREIGN KEY (GebruikerID) REFERENCES Gebruikers (GebruikerID)
);