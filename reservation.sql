-- Créer la table "reservations" dans votre base de données
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    email VARCHAR(50) NOT NULL,
    date DATE NOT NULL,
    heure TIME NOT NULL,
    activite VARCHAR(20) NOT NULL,
    nombre_personnes INT NOT NULL,
    prix_total DECIMAL(8,2) NOT NULL
);
