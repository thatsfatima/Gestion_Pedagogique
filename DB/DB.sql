
DROP FUNCTION IF EXISTS generate_matricule;
DELIMITER $$
CREATE FUNCTION generate_matricule() RETURNS VARCHAR(20)
DETERMINISTIC
BEGIN
    DECLARE new_matricule VARCHAR(20);
    DECLARE is_unique BOOLEAN DEFAULT FALSE;
    
    WHILE NOT is_unique DO
        SET new_matricule = CONCAT('MAT', LPAD(FLOOR(RAND() * 1000000), 4, '0'));
        SET is_unique = NOT EXISTS (SELECT 1 FROM etudiants WHERE matricule = new_matricule);
    END WHILE;
    
    RETURN new_matricule;
END$$

-- Réinitialiser le délimiteur
DELIMITER ;



CREATE TABLE IF NOT EXISTS roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    telephone VARCHAR(20) UNIQUE NOT NULL,
    login VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    id_role INT,
    FOREIGN KEY (id_role) REFERENCES roles(id)
);

CREATE TABLE IF NOT EXISTS professeurs (
    id INT PRIMARY KEY,
    specialite VARCHAR(255) NOT NULL,
    grade VARCHAR(255) NOT NULL,
    FOREIGN KEY (id) REFERENCES utilisateurs(id)
);

CREATE TABLE IF NOT EXISTS salles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    numero VARCHAR(255) NOT NULL,
    nombre_places INT NOT NULL
);

CREATE TABLE IF NOT EXISTS classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(255) NOT NULL,
    filiere VARCHAR(255) NOT NULL,
    niveau VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS modules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(255) NOT NULL
);

-- Nouvelle table pour l'année scolaire
CREATE TABLE IF NOT EXISTS annees_scolaires (
    id INT AUTO_INCREMENT PRIMARY KEY,
    annee_debut YEAR NOT NULL,
    annee_fin YEAR NOT NULL
);

-- Nouvelle table pour les semestres
CREATE TABLE IF NOT EXISTS semestres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(255) NOT NULL,
    id_annee_scolaire INT,
    FOREIGN KEY (id_annee_scolaire) REFERENCES annees_scolaires(id)
);

CREATE TABLE IF NOT EXISTS cours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_heure_global INT NOT NULL,
    semestre VARCHAR(255) NOT NULL,
    id_module INT,
    id_professeur INT,
    id_semestre INT,
    FOREIGN KEY (id_module) REFERENCES modules(id),
    FOREIGN KEY (id_professeur) REFERENCES professeurs(id),
    FOREIGN KEY (id_semestre) REFERENCES semestres(id)
);

CREATE TABLE IF NOT EXISTS session_cours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    heure_debut TIME NOT NULL,
    heure_fin TIME NOT NULL,
    nombre_heure INT NOT NULL,
    type_session ENUM('en ligne', 'en presentiel') NOT NULL DEFAULT 'en presentiel',
    etat_session ENUM('terminee', 'annulee', 'non effectuee') NOT NULL DEFAULT 'non effectuee',
    id_cours INT,
    id_salle INT,
    FOREIGN KEY (id_cours) REFERENCES cours(id),
    FOREIGN KEY (id_salle) REFERENCES salles(id)
);

CREATE TABLE IF NOT EXISTS demande_annulation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_demande DATE NOT NULL,
    raison TEXT NOT NULL,
    id_session INT,
    id_professeur INT,
    FOREIGN KEY (id_session) REFERENCES session_cours(id),
    FOREIGN KEY (id_professeur) REFERENCES professeurs(id)
);

CREATE TABLE IF NOT EXISTS cours_classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_cours INT,
    id_classe INT,
    FOREIGN KEY (id_cours) REFERENCES cours(id),
    FOREIGN KEY (id_classe) REFERENCES classes(id)
);



-- Table des étudiants héritant de utilisateurs
CREATE TABLE IF NOT EXISTS etudiants (
    id INT PRIMARY KEY,
    matricule VARCHAR(20) UNIQUE NOT NULL,
    FOREIGN KEY (id) REFERENCES utilisateurs(id)
);

-- Table des inscriptions
CREATE TABLE IF NOT EXISTS inscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_etudiant INT,
    id_classe INT,
    FOREIGN KEY (id_etudiant) REFERENCES etudiants(id),
    FOREIGN KEY (id_classe) REFERENCES classes(id)
);




INSERT INTO roles (libelle) VALUES ('Admin'), ('Professeur'), ('Etudiant');


-- Insert sample data into utilisateurs table
INSERT INTO utilisateurs (nom, prenom, email, telephone, login, password, id_role) VALUES
('Dieng', 'Mamadou', 'mamadou.dieng@example.com', '778123456', 'mamadou.dieng', 'password1', 1),
('Sarr', 'Fatou', 'fatou.sarr@example.com', '778654321', 'fatou.sarr', 'password2', 2),
('Diop', 'Aminata', 'aminata.diop@example.com', '778987654', 'aminata.diop', 'password3', 3);


-- Insert sample data into professeurs table
INSERT INTO professeurs (id, specialite, grade) VALUES
(2, 'Développement Web', 'Senior');


INSERT INTO salles (nom, numero, nombre_places) VALUES
('Salle 101', '101', 30),
('Salle 102', '102', 25);


-- Insert sample data into classes table
INSERT INTO classes (libelle, filiere, niveau) VALUES
('Classe A', 'Informatique', '1ere année'),
('Classe B', 'Informatique', '2e année');


INSERT INTO modules (libelle) VALUES
('Programmation Web'),
('Base de Données');



-- Insert sample data into annees_scolaires table
INSERT INTO annees_scolaires (annee_debut, annee_fin) VALUES
(2023, 2024),
(2024, 2025);


-- Insert sample data into semestres table
INSERT INTO semestres (libelle, id_annee_scolaire) VALUES
('Semestre 1', 1),
('Semestre 2', 1);



-- Insert sample data into cours table
INSERT INTO cours (nombre_heure_global, semestre, id_module, id_professeur, id_semestre) VALUES
(60, 'Semestre 1', 1, 2, 1),
(45, 'Semestre 2', 2, 2, 2);




-- Insert sample data into session_cours table
INSERT INTO session_cours (date, heure_debut, heure_fin, nombre_heure, type_session, etat_session, id_cours, id_salle) VALUES
('2024-01-10', '08:00:00', '10:00:00', 2, 'en presentiel', 'non effectuee', 1, 1),
('2024-01-11', '10:00:00', '12:00:00', 2, 'en ligne', 'non effectuee', 2, 2);


-- Insert sample data into demande_annulation table
INSERT INTO demande_annulation (date_demande, raison, id_session, id_professeur) VALUES
('2024-01-09', 'Maladie', 1, 2);



INSERT INTO cours_classes (id_cours, id_classe) VALUES
(1, 1),
(2, 2);


INSERT INTO etudiants (id, matricule) VALUES
(3, generate_matricule());


-- Insert sample data into inscriptions table
INSERT INTO inscriptions (id_etudiant, id_classe) VALUES
(3, 1);



SHOW TABLES;