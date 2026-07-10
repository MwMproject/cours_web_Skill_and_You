-- ============================================
-- EXERCICE 2 - API REST RECETTES
-- Script de création de la base de données
-- ============================================

CREATE DATABASE IF NOT EXISTS `recettes_api`
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE `recettes_api`;

-- ============================================
-- SUPPRESSION DE LA TABLE SI ELLE EXISTE
-- ============================================

DROP TABLE IF EXISTS `recettes`;

-- ============================================
-- TABLE recettes
-- Stocke les recettes de cuisine du monde
--
-- Choix des types :
--   id          : INT AUTO_INCREMENT  → identifiant unique auto-géré
--   nom         : VARCHAR(50)         → nom court, 50 caractères max
--   pays        : VARCHAR(50)         → pays d'origine, 50 caractères max
--   difficulte  : TINYINT UNSIGNED    → valeur entre 0 et 5, petit entier suffisant
--   detail      : TEXT                → jusqu'à 65 000 caractères (texte long)
-- ============================================

CREATE TABLE `recettes` (
    `id`         INT             NOT NULL AUTO_INCREMENT,
    `nom`        VARCHAR(50)     NOT NULL,
    `pays`       VARCHAR(50)     NOT NULL,
    `difficulte` TINYINT UNSIGNED NOT NULL CHECK (`difficulte` BETWEEN 0 AND 5),
    `detail`     TEXT            NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- DONNÉES DE TEST
-- ============================================

INSERT INTO `recettes` (`nom`, `pays`, `difficulte`, `detail`) VALUES
('Ratatouille',    'France',  2, 'Couper les légumes en rondelles. Faire revenir l\'oignon et l\'ail dans l\'huile d\'olive. Ajouter les courgettes, aubergines et tomates. Laisser mijoter 45 minutes à feu doux.'),
('Sushi',          'Japon',   4, 'Cuire le riz à sushi et l\'assaisonner avec du vinaigre de riz. Disposer une feuille de nori sur le makisu. Étaler le riz, ajouter le poisson cru et rouler fermement.'),
('Pasta Carbonara','Italie',  2, 'Cuire les pâtes al dente. Mélanger les jaunes d\'oeufs avec le pecorino râpé. Faire revenir le guanciale. Incorporer les pâtes hors du feu avec le mélange oeuf-fromage.');
