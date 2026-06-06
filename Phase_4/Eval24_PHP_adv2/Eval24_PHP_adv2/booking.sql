CREATE DATABASE IF NOT EXISTS `booking`
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE `booking`;

-- ============================================
-- SUPPRESSION DES TABLES
-- ============================================

DROP TABLE IF EXISTS `booking`;
DROP TABLE IF EXISTS `chambres`;
DROP TABLE IF EXISTS `hotels`;
DROP TABLE IF EXISTS `clients`;

-- ============================================
-- TABLE clients
-- Stocke les informations du client
-- qui effectue une réservation
-- ============================================

CREATE TABLE `clients` (
    `id`    INT          NOT NULL AUTO_INCREMENT,
    `nom`   VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL UNIQUE,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE hotels
-- Stocke les hôtels disponibles à la réservation
-- ============================================

CREATE TABLE `hotels` (
    `id`      INT          NOT NULL AUTO_INCREMENT,
    `nom`     VARCHAR(150) NOT NULL,
    `adresse` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE chambres
-- Chaque chambre est rattachée à un hôtel
-- ============================================

CREATE TABLE `chambres` (
    `id`        INT NOT NULL AUTO_INCREMENT,
    `numero`    INT NOT NULL,
    `hotel_id`  INT NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_chambres_hotel`
        FOREIGN KEY (`hotel_id`)
        REFERENCES `hotels` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE booking
-- Lie un client à une chambre sur une période
-- Règle : date_debut d'une nouvelle réservation
-- peut coïncider avec la date_fin d'une autre
-- ============================================

CREATE TABLE `booking` (
    `id`            INT      NOT NULL AUTO_INCREMENT,
    `date_debut`    DATE     NOT NULL,
    `date_fin`      DATE     NOT NULL,
    `date_creation` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `client_id`     INT      NOT NULL,
    `chambre_id`    INT      NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_booking_client`
        FOREIGN KEY (`client_id`)
        REFERENCES `clients` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `fk_booking_chambre`
        FOREIGN KEY (`chambre_id`)
        REFERENCES `chambres` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- DONNÉES DE TEST
-- 2 hôtels, 3 chambres chacun
-- ============================================

INSERT INTO `hotels` (`nom`, `adresse`) VALUES
('Hôtel Le Lac',     '12 rue du Lac, 75001 Paris'),
('Hôtel Les Alpes',  '5 avenue des Alpes, 69001 Lyon');

INSERT INTO `chambres` (`numero`, `hotel_id`) VALUES
(101, 1),
(102, 1),
(103, 1),
(101, 2),
(102, 2),
(103, 2);
