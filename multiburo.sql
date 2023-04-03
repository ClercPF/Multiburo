-- Création de la BDD
CREATE DATABASE clerc_multiburo;
USE clerc_multiburo;

-- Création des Tables
CREATE TABLE organisation(
    id_orga INT AUTO_INCREMENT,
    rs_orga VARCHAR(100),
    adr_orga VARCHAR(200),
    cp_orga VARCHAR(10),
    ville_orga VARCHAR(100),
    tel_orga VARCHAR(15),
    CONSTRAINT pk_organisation PRIMARY KEY (id_orga)
);

CREATE TABLE utilisateur(
    id_util INT AUTO_INCREMENT,
    nom_util VARCHAR(100),
    prenom_util VARCHAR(100),
    adr_util VARCHAR(200),
    cp_util VARCHAR(10),
    ville_util VARCHAR(100),
    tel_util VARCHAR(15),
    email_util VARCHAR(100) NOT NULL UNIQUE,
    mdp_util VARCHAR(200) NOT NULL,
    id_orga INT,
    CONSTRAINT pk_utilisateur PRIMARY KEY(id_util),
    CONSTRAINT fk_util_orga FOREIGN KEY(id_orga) REFERENCES organisation(id_orga)
);

CREATE TABLE abonnement(
    code_abo VARCHAR(10),
    lib_abo VARCHAR(50),
    duree_abo INT NOT NULL,
    prix_abo DOUBLE(8,2) NOT NULL,
    CONSTRAINT pk_abonnement PRIMARY KEY (code_abo)
);

CREATE TABLE type_ressource(
    code_type VARCHAR(2),
    lib_type VARCHAR(20) NOT NULL,
    CONSTRAINT pk_type_ressource PRIMARY KEY (code_type)
);

CREATE TABLE ressource(
    id_ress INT AUTO_INCREMENT,
    lib_ress VARCHAR(50) NOT NULL,
    nb_place_ress INT,
    num_serie_ress VARCHAR(50),
    etat_ress VARCHAR(200),
    code_type VARCHAR(2),
    CONSTRAINT pk_ressource PRIMARY KEY (id_ress),
    CONSTRAINT fk_ress_type FOREIGN KEY(code_type) REFERENCES type_ressource(code_type)
);

CREATE TABLE reservation(
    id_res INT AUTO_INCREMENT,
    date_res DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_util INT,
    CONSTRAINT pk_reservation PRIMARY KEY (id_res),
    CONSTRAINT fk_res_util FOREIGN KEY(id_util) REFERENCES utilisateur(id_util)
);

CREATE TABLE habo(
    id_util INT, 
    code_abo VARCHAR(10),
    date_habo DATE NOT NULL,
    CONSTRAINT pk_habo PRIMARY KEY (id_util, code_abo, date_habo),
    CONSTRAINT fk_habo_util FOREIGN KEY(id_util) REFERENCES utilisateur(id_util),
    CONSTRAINT fk_habo_abo FOREIGN KEY(code_abo) REFERENCES abonnement(code_abo)
);

CREATE TABLE detabo(
    code_abo VARCHAR(10),
    code_type VARCHAR(2),
    CONSTRAINT pk_detabo PRIMARY KEY (code_abo, code_type),
    CONSTRAINT fk_detabo_abo FOREIGN KEY(code_abo) REFERENCES abonnement(code_abo),
    CONSTRAINT fk_detabo_type FOREIGN KEY(code_type) REFERENCES type_ressource(code_type)
);

CREATE TABLE ligneres(
    id_res INT, 
    id_ress INT,
    CONSTRAINT pk_ligneres PRIMARY KEY (id_res, id_ress),
    CONSTRAINT fk_ligneres_res FOREIGN KEY(id_res) REFERENCES reservation(id_res),
    CONSTRAINT fk_ligneres_ress FOREIGN KEY(id_ress) REFERENCES ressource(id_ress)
);

-- Ajout des données des tables systeme
INSERT INTO type_ressource(code_type, lib_type)
VALUES('BI', 'Bureau Individuel');
INSERT INTO type_ressource(code_type, lib_type)
VALUES('SR', 'Salle de Réunion');
INSERT INTO type_ressource(code_type, lib_type)
VALUES('OS', 'Open Space');
INSERT INTO type_ressource(code_type, lib_type)
VALUES('OP', 'Ordinateur Portable');
INSERT INTO type_ressource(code_type, lib_type)
VALUES('PK', 'Place de Parking');

INSERT INTO organisation(rs_orga)
VALUES('IDEPENDANT');
INSERT INTO utilisateur(nom_util, prenom_util, adr_util, cp_util, ville_util, tel_util, email_util, mdp_util, id_orga)
VALUES('CLERC', 'Mira', '2 Allée Charles Martel', '38200', 'VIENNE', '0627272727', 'mira@multi.fr', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 1);

-- création du user MySQL pour le Front Office
CREATE USER 'multiweb'@'localhost'
IDENTIFIED BY '3h-m4Q@sLJ5$';

GRANT SELECT 
ON clerc_multiburo.*
TO 'multiweb'@'localhost';

GRANT INSERT, UPDATE, DELETE 
ON clerc_multiburo.reservation
TO 'multiweb'@'localhost';

GRANT INSERT, UPDATE, DELETE 
ON clerc_multiburo.ligneres
TO 'multiweb'@'localhost';