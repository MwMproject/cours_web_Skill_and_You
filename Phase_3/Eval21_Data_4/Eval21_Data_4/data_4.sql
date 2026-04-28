-- ============================================
-- DATA 4
-- Scripts d'alimentation de la base de test
-- ============================================

-- Base de données : dbb_data4_ecole selon l'annexe 1
USE `dbb_data4_ecole`;

-- ============================================
-- QUESTION 1.1
-- Alimentation de la table formations
-- Selon l'annexe 2 - fichier .txt
-- Étapes :
--   1. Ouvrir le fichier .txt
--   2. Identifier les séparateurs : virgule (,) entre les champs,
--      point-virgule (;) entre chaque enregistrement
--   3. Mapper les champs :
--      - 1er champ  -> id_formation
--      - 2ème champ -> nom_formation
--      - 3ème champ -> desc_formation
--   4. Générer les INSERT correspondants ci-dessous
-- ============================================

INSERT INTO `formations` (`id_formation`, `nom_formation`, `desc_formation`) VALUES
(1, 'Titre professionnel Développeur web et web mobile', 'Description de la formation de développeur web et web mobile'),
(2, 'Webdesigner', 'Description de la formation de webdesigner'),
(3, 'Integrateur-developpeur', 'Description de la formation de integrateur-developpeur');

-- ============================================
-- QUESTION 1.2
-- Alimentation des tables matieres et cours
-- Selon l'annexe 3 - fichier Excel
-- ============================================

INSERT INTO `matieres` (`id_matiere`, `nom_matiere`, `desc_matiere`) VALUES
(1, 'PHP initiation', 'Matière consacrée aux bases du langage PHP'),
(2, 'PHP intermédiaire', 'Matière consacrée à PHP et aux bases de données'),
(3, 'Gérer une base de données', 'Matière consacrée à la conception et à la gestion des bases de données');

INSERT INTO `cours` (`id_cours`, `nom_cours`, `desc_cours`, `id_matiere`) VALUES
-- PHP initiation (id_matiere = 1)
(1,  'Installation et fonctionnement', 'Cours PHP initiation', 1),
(2,  'Bien démarrer en PHP', 'Cours PHP initiation', 1),
(3,  'Les variables et constantes', 'Cours PHP initiation', 1),
(4,  'Les conditions, les opérateurs et les boucles', 'Cours PHP initiation', 1),
(5,  'Tableaux de données', 'Cours PHP initiation', 1),
(6,  'Variables prédéfinies et variables externes', 'Cours PHP initiation', 1),
(7,  'PHP et les formulaires', 'Cours PHP initiation', 1),
-- PHP intermédiaire (id_matiere = 2)
(8,  'Qu''est-ce qu''une base de données', 'Cours PHP intermédiaire', 2),
(9,  'MySQL', 'Cours PHP intermédiaire', 2),
(10, 'Premier script PHP-MySQL', 'Cours PHP intermédiaire', 2),
(11, 'Les requêtes MySQL', 'Cours PHP intermédiaire', 2),
(12, 'Les types de données MySQL', 'Cours PHP intermédiaire', 2),
(13, 'Réalisation d''un site de contenu en base de données', 'Cours PHP intermédiaire', 2),
(14, 'Les sessions', 'Cours PHP intermédiaire', 2),
(15, 'Les cookies', 'Cours PHP intermédiaire', 2),
-- Gérer une base de données (id_matiere = 3)
(16, 'Recenser les informations du domaine étudié', 'Cours de gestion de base de données', 3),
(17, 'Organiser les données', 'Cours de gestion de base de données', 3),
(18, 'Construire l''organisation physique des données', 'Cours de gestion de base de données', 3),
(19, 'Mettre en oeuvre les instructions de création, de modification et de suppression de base de données', 'Cours de gestion de base de données', 3),
(20, 'Mettre en oeuvre les instructions pour implémenter les contraintes et l''optimisation des accès', 'Cours de gestion de base de données', 3),
(21, 'Ecrire et exécuter un script de création de base de données à l''aide de l''environnement intégré de développement', 'Cours de gestion de base de données', 3),
(22, 'Générer un script de création de la base de données à l''aide de l''outil de modélisation', 'Cours de gestion de base de données', 3),
(23, 'Elaborer des scripts d''alimentation de la base de test', 'Cours de gestion de base de données', 3),
(24, 'Les avantages et inconvénients du relationnel et du non-relationnel', 'Cours de gestion de base de données', 3),
(25, 'Le langage de requête pour la base de données', 'Cours de gestion de base de données', 3),
(26, 'Outil de sauvegarde de base de données', 'Cours de gestion de base de données', 3);

-- Association de la formation Développeur web aux 3 matières
INSERT INTO `formations_matieres` (`id_formation`, `id_matiere`, `date_deb`, `date_fin`) VALUES
(1, 1, '2024-01-01', '2024-12-31'),
(1, 2, '2024-01-01', '2024-12-31'),
(1, 3, '2024-01-01', '2024-12-31');

-- ============================================
-- QUESTION 2
-- Cas particulier : Weiss Manuel
-- Formation : Titre professionnel Développeur web et web mobile
-- Devoir : DEVOIR 1 - Elaborer des scripts d'alimentation de la base de test
-- ============================================

-- Étape 1 : Insertion de l'élève
INSERT INTO `eleves` (`nom_eleve`, `prenom_eleve`) VALUES
('Weiss', 'Manuel');

-- Étape 2 : Association à la formation Développeur web (id_formation = 1)
-- Note : id_eleve = 19 car AUTO_INCREMENT=19 d'après l'annexe
INSERT INTO `eleves_formations` (`id_eleve`, `id_formation`, `date_deb_formation`, `date_fin_formation`) VALUES
(19, 1, '2024-01-01', '2024-12-31');

-- Étape 3 : Insertion du devoir lié au cours 23
-- "Elaborer des scripts d'alimentation de la base de test"
INSERT INTO `devoirs` (`nom_devoir`, `num_devoir`, `desc_devoir`, `id_cours`) VALUES
('DEVOIR 1 - Elaborer des scripts d''alimentation de la base de test', 1, 'Devoir portant sur l''élaboration de scripts d''alimentation de la base de test', 23);