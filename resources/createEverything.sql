CREATE DATABASE IF NOT EXISTS navire;

USE navire;
SHOW TABLES;
#SELECT * FROM aisshiptype;

# Dans fichier .env : DATABASE_URL="DBMS://username:password@IP:Port/NomDB"
# symfony console make:migration (fichiers dans dossier migrations montre les modifs à venir)
# symfony console doctrine:migrations:migrate

DROP TABLE IF EXISTS aisshiptype, message, pays, port, navire, escale, porttypecompatible;

CREATE TABLE IF NOT EXISTS aisshiptype (
	id INT PRIMARY KEY NOT NULL, 
    aisshiptype INT, 
    libelle VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS message (
    id INT AUTO_INCREMENT NOT NULL,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    mail VARCHAR(255) NOT NULL,
    message VARCHAR(255) NOT NULL,
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` 
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS pays (
	id INT PRIMARY KEY NOT NULL, 
    nom VARCHAR(255), 
    indicatif VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS port (
	id INT PRIMARY KEY NOT NULL, 
    idpays INT, 
    nom VARCHAR(255), 
    indicatif VARCHAR(255),
    FOREIGN KEY (idpays) REFERENCES pays(id)
);

CREATE TABLE IF NOT EXISTS navire (
	id INT PRIMARY KEY NOT NULL, 
    imo VARCHAR(255), 
    nom VARCHAR(255), 
    mmsi VARCHAR(255), 
    indicatifappel VARCHAR(255), 
    eta DATETIME, 
    idAisShipType INT, 
    idpays INT, 
    idport INT, 
    longueur INT, 
    largeur INT, 
    tirantdeau DECIMAL,
    FOREIGN KEY (idAisShipType) REFERENCES aisshitype(id),
    FOREIGN KEY (idpays) REFERENCES pays(id),
    FOREIGN KEY (idport) REFERENCES port(id)
);

CREATE TABLE IF NOT EXISTS escale (
	id INT PRIMARY KEY NOT NULL, 
    idnavire INT, 
    idPort INT, 
    dateheurearrivee DATETIME, 
    dateheuredepart DATETIME,
    FOREIGN KEY (idnavire) REFERENCES navire(id),
    FOREIGN KEY (idPort) REFERENCES port(id)
);

CREATE TABLE IF NOT EXISTS porttypecompatible (
	idaisshiptype INT, 
    idport INT,
    FOREIGN KEY (idaisshiptype) REFERENCES aisshiptype(id),
    FOREIGN KEY (idport) REFERENCES port(id)
);