CREATE DATABASE IF NOT EXISTS navire;
USE navire;

SHOW TABLES;
SELECT * FROM message;

# Dans fichier .env : DATABASE_URL="DBMS://username:password@IP:Port/NomDB"
# symfony console make:migration
# symfony console doctrine:migrations:migrate

CREATE TABLE message (
    id INT AUTO_INCREMENT NOT NULL,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    mail VARCHAR(255) NOT NULL,
    message VARCHAR(255) NOT NULL,
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` 
ENGINE = InnoDB