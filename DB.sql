-- Active: 1719244381648@@127.0.0.1@3306@Pedagogique
CREATE TABLE IF NOT EXISTS role (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(60) NOT NULL,
    email VARCHAR(60) UNIQUE NOT NULL,
    telephone VARCHAR(20) UNIQUE NOT NULL,
    login VARCHAR(60) UNIQUE NOT NULL,
    password VARCHAR(50) NOT NULL,
    id_role INT,
    FOREIGN KEY (id_role) REFERENCES role(id)
);

CREATE TABLE IF NOT EXISTS professeur (
    id INT PRIMARY KEY,
    specialite VARCHAR(100) NOT NULL,
    grade VARCHAR(100) NOT NULL,
    FOREIGN KEY (id) REFERENCES user(id)
);

CREATE TABLE IF NOT EXISTS salle (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    numero VARCHAR(30) NOT NULL,
    nombrePlaces INT NOT NULL
);

CREATE TABLE IF NOT EXISTS classe (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(30) NOT NULL,
    filiere VARCHAR(30) NOT NULL,
    niveau VARCHAR(30) NOT NULL
);

CREATE TABLE IF NOT EXISTS module (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS cours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombreHeureGlobal INT NOT NULL,
    semestre VARCHAR(30) NOT NULL,
    id_module INT,
    id_professeur INT,
    FOREIGN KEY (id_module) REFERENCES module(id),
    FOREIGN KEY (id_professeur) REFERENCES professeur(id)
);

CREATE TABLE IF NOT EXISTS sessionCours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    heureDebut TIME NOT NULL,
    heureFin TIME NOT NULL,
    nombreHeure INT NOT NULL,
    typeSession ENUM('ligne', 'presentiel') NOT NULL DEFAULT 'presentiel',
    etatSession ENUM('terminee', 'annulee', 'non_effectuee') NOT NULL DEFAULT 'non_effectuee',
    id_cours INT,
    id_salle INT,
    FOREIGN KEY (id_cours) REFERENCES cours(id),
    FOREIGN KEY (id_salle) REFERENCES salle(id)
);
ALTER TABLE sessionCours MODIFY date DATE FORMAT 'dd/mm/yyyy';

CREATE TABLE IF NOT EXISTS demande_annulation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dateDemande DATE NOT NULL,
    raison TEXT NOT NULL,
    id_session INT,
    id_professeur INT,
    FOREIGN KEY (id_session) REFERENCES sessionCours(id),
    FOREIGN KEY (id_professeur) REFERENCES professeur(id)
);

CREATE TABLE IF NOT EXISTS cours_classe (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_cours INT,
    id_classe INT,
    FOREIGN KEY (id_cours) REFERENCES cours(id),
    FOREIGN KEY (id_classe) REFERENCES classe(id)
);

-- Nouvelle table pour l'année scolaire
CREATE TABLE IF NOT EXISTS anneeScolaire (
    id INT AUTO_INCREMENT PRIMARY KEY,
    anneeDebut YEAR NOT NULL,
    anneedFin YEAR NOT NULL
);

-- Nouvelle table pour les semestres
CREATE TABLE IF NOT EXISTS semestre (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(50) NOT NULL,
    id_annee_scolaire INT,
    FOREIGN KEY (id_annee_scolaire) REFERENCES anneeScolaire(id)
);

-- Table des étudiants héritant de user
CREATE TABLE IF NOT EXISTS etudiant (
    id INT PRIMARY KEY,
    matricule VARCHAR(20) UNIQUE NOT NULL,
    FOREIGN KEY (id) REFERENCES user(id)
);

-- Table des 
CREATE TABLE IF NOT EXISTS inscription (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_etudiant INT,
    id_classe INT,
    FOREIGN KEY (id_etudiant) REFERENCES etudiant(id),
    FOREIGN KEY (id_classe) REFERENCES classe(id)
);

ALTER TABLE cours ADD FOREIGN KEY (semestre_id) REFERENCES semestre(id);

DELIMITER $$
CREATE TRIGGER matricule
BEFORE UPDATE ON etudiant
FOR EACH ROW
BEGIN
    SET NEW.matricule = CONCAT('MAT', LPAD(FLOOR(RAND() * 1000000), 4, '0'));
END$$
DELIMITER ;

-- Définir le délimiteur pour la fonction
DELIMITER $$

CREATE FUNCTION generate_matricule() RETURNS VARCHAR(20)
DETERMINISTIC
BEGIN
    DECLARE new_matricule VARCHAR(20);
    DECLARE is_unique BOOLEAN DEFAULT FALSE;
    
    WHILE NOT is_unique DO
        SET new_matricule = CONCAT('MAT', LPAD(FLOOR(RAND() * 1000000), 4, '0'));
        SET is_unique = NOT EXISTS (SELECT 1 FROM etudiant WHERE matricule = new_matricule);
    END WHILE;
    
    RETURN new_matricule;
END$$

-- Réinitialiser le délimiteur
DELIMITER ;