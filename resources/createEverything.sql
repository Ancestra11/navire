CREATE DATABASE IF NOT EXISTS navire;

USE navire;
SHOW TABLES;
#SELECT * FROM aisshiptype;

#CREATE USER 'usernavire'@'localhost' IDENTIFIED BY 'usernavire';
#GRANT ALL PRIVILEGES ON navire.* TO 'usernavire'@'localhost';
#GRANT CREATE, DROP ON *.* TO 'databasecreator'@'localhost';

# Dans fichier .env : DATABASE_URL="DBMS://username:password@IP:Port/NomDB"
# symfony console make:migration (fichiers dans dossier migrations montre les modifs à venir)
# symfony console doctrine:migrations:migrate
SHOW TABLES; 
DESCRIBE port;
DROP TABLE IF EXISTS aisshiptype, message, pays, port, navire, escale, porttypecompatible;

SELECT DISTINCT pays.nom FROM pays INNER JOIN port ON pays.id = port.idpays WHERE port.idpays = 60;
