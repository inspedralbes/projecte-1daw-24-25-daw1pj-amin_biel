-- Aquest script NOMÉS s'executa la primera vegada que es crea el contenidor.
-- Si es vol recrear les taules de nou cal esborrar el contenidor, o bé les dades del contenidor
-- és a dir, 
-- esborrar el contingut de la carpeta db_data 
-- o canviant el nom de la carpeta, però atenció a no pujar-la a git


-- És un exemple d'script per crear una base de dades i una taula
-- i afegir-hi dades inicials

-- Si creem la BBDD aquí podem control·lar la codificació i el collation
-- en canvi en el docker-compose no podem especificar el collation ni la codificació

-- Per assegurar-nes de que la codificació dels caràcters d'aquest script és la correcta
SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS persones
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

-- Donem permisos a l'usuari 'usuari' per accedir a la base de dades 'persones'
-- sinó, aquest usuari no podrà veure la base de dades i no podrà accedir a les taules
GRANT ALL PRIVILEGES ON persones.* TO 'usuari'@'%';
FLUSH PRIVILEGES;

-- Després de crear la base de dades, cal seleccionar-la per treballar-hi
USE persones;

CREATE TABLE DEPARTAMENTS(
  ID_DEPARTAMENT INT AUTO_INCREMENT PRIMARY KEY,
  DESCRIPCIO VARCHAR(50)
);
CREATE TABLE ESTAT (
  ID_ESTAT INT AUTO_INCREMENT PRIMARY KEY,
  DESCRIPCIO VARCHAR(50)

);
CREATE TABLE INCIDENCIES (
  ID_INCIDENCIA INT AUTO_INCREMENT PRIMARY KEY,
  ID_DEPARTAMENT INT NOT NULL,
  DATA_INICI DATE not null,
  DESCRIPCIO TEXT not null,
  ID_ESTAT INT NOT NULL DEFAULT 1,
  ORDINADOR INT NOT NULL,
  FOREIGN KEY (ID_DEPARTAMENT) REFERENCES DEPARTAMENTS(ID_DEPARTAMENT),
  FOREIGN KEY (ID_ESTAT) REFERENCES ESTAT(ID_ESTAT)
);

INSERT INTO DEPARTAMENTS (DESCRIPCIO) VALUES ('Matemàtiques');
INSERT INTO DEPARTAMENTS (DESCRIPCIO) VALUES ('Ciències Naturals');
INSERT INTO DEPARTAMENTS (DESCRIPCIO) VALUES ('Tecnologia');
INSERT INTO DEPARTAMENTS (DESCRIPCIO) VALUES ('Llengües');
INSERT INTO DEPARTAMENTS (DESCRIPCIO) VALUES ('Ciències Socials');
INSERT INTO DEPARTAMENTS (DESCRIPCIO) VALUES ('Educació Física');
INSERT INTO DEPARTAMENTS (DESCRIPCIO) VALUES ('Arts Plàstiques');
INSERT INTO DEPARTAMENTS (DESCRIPCIO) VALUES ('Música');
INSERT INTO DEPARTAMENTS (DESCRIPCIO) VALUES ('Informàtica');
INSERT INTO DEPARTAMENTS (DESCRIPCIO) VALUES ('Biblioteca');

INSERT INTO ESTAT (DESCRIPCIO) VALUES ('Sense Assignar');
INSERT INTO ESTAT (DESCRIPCIO) VALUES ('En Procés');
INSERT INTO ESTAT (DESCRIPCIO) VALUES ('Acabada');
