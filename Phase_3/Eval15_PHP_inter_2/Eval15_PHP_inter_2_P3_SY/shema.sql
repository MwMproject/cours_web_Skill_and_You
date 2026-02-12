-- Shéma SQL qui contient les tables pour les produits, les paniers d'achat et les items dans les paniers
CREATE TABLE produits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prix INT NOT NULL
);

-- Insertion des produits dans la table produits
INSERT INTO produits (nom, prix) VALUES
('Produit A', 9),
('Produit B', 19),
('Produit C', 79),
('Produit D', 5),
('Produit E', 45),
('Produit F', 29),
('Produit G', 10);

-- Table pour les paniers d'achat
CREATE TABLE paniers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_at DATETIME NOT NULL
);

-- Table pour les items dans les paniers
CREATE TABLE panier_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    panier_id INT NOT NULL,
    produit_id INT NOT NULL,
    quantite INT NOT NULL DEFAULT 1,
    FOREIGN KEY (panier_id) REFERENCES paniers(id),
    FOREIGN KEY (produit_id) REFERENCES produits(id)
);
