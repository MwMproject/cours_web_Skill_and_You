-- ============================================
-- Data 4
-- Élaborer des scripts d'alimentation de la base de test
-- ============================================

USE `dbb_data4_ecole`;

INSERT INTO `formations` (`id_formation`, `nom_formation`, `desc_formation`) VALUES
(1, 'Titre professionnel Développeur web et web mobile', 'Description de la formation de développeur web et web mobile'),
(2, 'Webdesigner', 'Description de la formation de webdesigner'),
(3, 'Integrateur-developpeur', 'Description de la formation de integrateur-developpeur');


-- Table matieres
INSERT INTO `matieres` (`id_matiere`, `nom_matiere`, `desc_matiere`) VALUES
(1, 'PHP initiation', NULL),
(2, 'PHP intermédiaire', NULL),
(3, 'Gérer une base de données', NULL);

-- Table cours
INSERT INTO `cours` (`id_cours`, `nom_cours`, `desc_cours`, `id_matiere`) VALUES
-- PHP initiation (id_matiere = 1)
(1,  'Installation et fonctionnement', NULL, 1),
(2,  'Bien démarrer en PHP', NULL, 1),
(3,  'Les variables et constantes', NULL, 1),
(4,  'Les conditions, les opérateurs et les boucles', NULL, 1),
(5,  'Tableaux de données', NULL, 1),
(6,  'Variables prédéfinies et variables externes', NULL, 1),
(7,  'PHP et les formulaires', NULL, 1),
-- PHP intermédiaire (id_matiere = 2)
(8,  'Qu\'est-ce qu\'une base de données', NULL, 2),
(9,  'MySQL', NULL, 2),
(10, 'Premier script PHP-MySQL', NULL, 2),
(11, 'Les requêtes MySQL', NULL, 2),
(12, 'Les types de données MySQL', NULL, 2),
(13, 'Réalisation d\'un site de contenu en base de données', NULL, 2),
(14, 'Les sessions', NULL, 2),
(15, 'Les cookies', NULL, 2),
-- Gérer une base de données (id_matiere = 3)
(16, 'Recenser les informations du domaine étudié', NULL, 3),
(17, 'Organiser les données', NULL, 3),
(18, 'Construire l\'organisation physique des données', NULL, 3),
(19, 'Mettre en oeuvre les instructions de création, de modification et de suppression de base de données', NULL, 3),
(20, 'Mettre en oeuvre les instructions pour implémenter les contraintes et l\'optimisation des accès', NULL, 3),
(21, 'Ecrire et exécuter un script de création de base de données à l\'aide de l\'environnement intégré de développement', NULL, 3),
(22, 'Générer un script de création de la base de données à l\'aide de l\'outil de modélisation', NULL, 3),
(23, 'Elaborer des scripts d\'alimentation de la base de test', NULL, 3),
(24, 'Les avantages et inconvénients du relationnel et du non-relationnel', NULL, 3),
(25, 'Le langage de requête pour la base de données', NULL, 3),
(26, 'Outil de sauvegarde de base de données', NULL, 3);


-- Étape 1 : Insertion de l'élève
INSERT INTO `eleves` (`nom_eleve`, `prenom_eleve`) VALUES
('Weiss', 'Manuel');

-- Récupération de l'id_eleve inséré 

INSERT INTO `eleves_formations` (`id_eleve`, `id_formation`, `date_deb_formation`, `date_fin_formation`) VALUES
(19, 1, '2024-01-01', '2024-12-31');

-- Étape 3 : Insertion du devoir lié au cours 
INSERT INTO `devoirs` (`nom_devoir`, `num_devoir`, `desc_devoir`, `id_cours`) VALUES
('DEVOIR 1 - Elaborer des scripts d\'alimentation de la base de test', 1, 'Elaborer des scripts d\'alimentation de la base de test', 23);