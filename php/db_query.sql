USE lootjes_lootjes;
DROP TABLE IF EXISTS DeelnemerDetails;
DROP TABLE IF EXISTS Groep;
DROP TABLE IF EXISTS Deelnemers;
DROP TABLE IF EXISTS Oprichter;



CREATE TABLE Groep (
    `GroepId` INT NOT NULL AUTO_INCREMENT,
    `GroepsNaam` VARCHAR(255) NOT NULL,
    `Bedrag` INT NULL,
    `DatumViering` DATE NOT NULL,
    `DatumTrekking` INT(3) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (GroepId)
);

CREATE TABLE Deelnemers (
    `DeelnemerId` INT NOT NULL AUTO_INCREMENT,
    `DeelnemersNaam` VARCHAR(255),
    `Email` VARCHAR(50),
    `Postcode` VARCHAR(6),
    `Telefoonnummer` VARCHAR(15),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (DeelnemerId)
);

CREATE TABLE Oprichter (
    `OprichterId` INT NOT NULL AUTO_INCREMENT,
    `OprichtersNaam` VARCHAR(255) NOT NULL,
    `Email` VARCHAR(255) NULL,
    `Bericht` VARCHAR(255),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (OprichterId)
);

CREATE TABLE DeelnemerDetails (
    `DetailsId` INT NOT NULL AUTO_INCREMENT,
    `DeelnemerId` INT NULL,
    `OprichterId` INT NULL,
    `GroepId` INT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (DetailsId),
    FOREIGN KEY (DeelnemerId) REFERENCES Deelnemers(DeelnemerId),
    FOREIGN KEY (OprichterId) REFERENCES Oprichter(OprichterId),
    FOREIGN KEY (GroepId) REFERENCES Groep(GroepId)
);
