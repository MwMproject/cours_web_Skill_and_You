-- ============================================
-- Eval 17 - Data 2
-- Création et gestion de base de données
-- ============================================

-- Supprime la base si elle existe déjà
DROP DATABASE IF EXISTS ecole_rdv;

-- Crée la base de données
CREATE DATABASE ecole_rdv;

-- Sélectionne la base
USE ecole_rdv;

-- Table des élèves
CREATE TABLE eleves (
    eleve_id INT AUTO_INCREMENT PRIMARY KEY,
    eleve_nom VARCHAR(50),
    eleve_prenom VARCHAR(50)
);

-- Table des professeurs
CREATE TABLE professeurs (
    professeur_id INT AUTO_INCREMENT PRIMARY KEY,
    professeur_nom VARCHAR(50),
    professeur_prenom VARCHAR(50)
);

-- Table des matières
CREATE TABLE matieres (
    matiere_id INT AUTO_INCREMENT PRIMARY KEY,
    matiere_nom VARCHAR(50)
);

-- Table des cours liés à une matière
CREATE TABLE cours (
    cours_id INT AUTO_INCREMENT PRIMARY KEY,
    cours_nom VARCHAR(50),
    cours_desc VARCHAR(250),
    matiere_id INT,
    FOREIGN KEY (matiere_id) REFERENCES matieres(matiere_id)
);

-- Table des devoirs liés à un cours
CREATE TABLE devoirs (
    devoir_id INT AUTO_INCREMENT PRIMARY KEY,
    devoir_nom VARCHAR(250),
    devoir_desc TEXT,
    cours_id INT,
    FOREIGN KEY (cours_id) REFERENCES cours(cours_id)
);

-- Table des rendez-vous
CREATE TABLE rendez_vous (
    rdv_id INT AUTO_INCREMENT PRIMARY KEY,
    eleve_id INT,
    matiere_id INT,
    professeur_id INT,
    rdv_date DATE,
    rdv_h_deb TIME,
    rdv_h_fin TIME,
    FOREIGN KEY (eleve_id) REFERENCES eleves(eleve_id),
    FOREIGN KEY (matiere_id) REFERENCES matieres(matiere_id),
    FOREIGN KEY (professeur_id) REFERENCES professeurs(professeur_id)
);

-- Table de liaison entre professeurs et matières
CREATE TABLE enseigner (
    enseigner_id INT AUTO_INCREMENT PRIMARY KEY,
    professeur_id INT,
    matiere_id INT,
    date_deb_ens DATE,
    date_fin_ens DATE,
    FOREIGN KEY (professeur_id) REFERENCES professeurs(professeur_id),
    FOREIGN KEY (matiere_id) REFERENCES matieres(matiere_id)
);

-- Création des utilisateurs
CREATE USER IF NOT EXISTS 'eleve1'@'localhost' IDENTIFIED BY 'password';
CREATE USER IF NOT EXISTS 'prof1'@'localhost' IDENTIFIED BY 'password';

-- Création des rôles
CREATE ROLE IF NOT EXISTS 'eleve';
CREATE ROLE IF NOT EXISTS 'professeur';

-- Droits du rôle élève sur les rendez-vous
GRANT SELECT, INSERT, UPDATE, DELETE
ON ecole_rdv.rendez_vous
TO 'eleve';

-- Droits du rôle professeur sur les rendez-vous
GRANT SELECT, DELETE
ON ecole_rdv.rendez_vous
TO 'professeur';

-- Droits du rôle professeur sur les cours
GRANT SELECT, INSERT, UPDATE
ON ecole_rdv.cours
TO 'professeur';

-- Attribution des rôles aux utilisateurs
GRANT 'eleve' TO 'eleve1'@'localhost';
GRANT 'professeur' TO 'prof1'@'localhost';

-- Met à jour les privilèges
FLUSH PRIVILEGES;