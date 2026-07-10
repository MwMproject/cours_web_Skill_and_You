<?php

declare(strict_types=1);

// ============================================
// recettes.php
// Point d'accès unique de l'API REST
// Méthodes supportées : GET, POST
// Format de réponse   : JSON
// ============================================

// ============================================
// CONNEXION À LA BASE DE DONNÉES
// ============================================

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=recettes_api;charset=utf8mb4',
        'root',
        '',
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    // Erreur de connexion : on retourne une réponse JSON et on stoppe
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'content' => 'Erreur de connexion à la base de données',
    ]);
    exit;
}

// ============================================
// FONCTION : récupérer une ou toutes les recettes
//
// Si $id est un entier valide → retourne la recette correspondante
// Sinon                       → retourne toutes les recettes
// ============================================

function getRecettes(mixed $id, PDO $pdo): array
{
    if (is_numeric($id)) {
        // Récupération d'une recette spécifique par son id
        $sql = "SELECT `id`, `nom`, `pays`, `difficulte`, `detail`
                FROM `recettes`
                WHERE `id` = :id";
        $request = $pdo->prepare($sql);
        $request->bindParam(':id', $id, PDO::PARAM_INT);
    } else {
        // Récupération de toutes les recettes
        $sql = "SELECT `id`, `nom`, `pays`, `difficulte`, `detail`
                FROM `recettes`";
        $request = $pdo->prepare($sql);
    }

    $request->execute();

    // Construction du tableau de résultats
    $recettes = [];
    while ($recette = $request->fetch()) {
        $recettes[] = $recette;
    }

    return $recettes;
}

// ============================================
// FONCTION : ajouter une recette
//
// Insère une nouvelle recette en base de données
// Les paramètres sont déjà validés avant l'appel
// ============================================

function postRecettes(string $nom, string $pays, int $difficulte, string $detail, PDO $pdo): void
{
    $sql = "INSERT INTO `recettes` (`nom`, `pays`, `difficulte`, `detail`)
            VALUES (:nom, :pays, :difficulte, :detail)";

    $request = $pdo->prepare($sql);
    $request->bindParam(':nom',        $nom,        PDO::PARAM_STR);
    $request->bindParam(':pays',       $pays,       PDO::PARAM_STR);
    $request->bindParam(':difficulte', $difficulte, PDO::PARAM_INT);
    $request->bindParam(':detail',     $detail,     PDO::PARAM_STR);
    $request->execute();
}

// ============================================
// CONTRÔLEUR
// Identifie la méthode HTTP et dispatch
// ============================================

switch ($_SERVER['REQUEST_METHOD']) {

    // ========================================
    // GET : récupérer une ou toutes les recettes
    // Paramètre optionnel : ?id=X
    // ========================================
    case 'GET':

        $id       = !empty($_GET['id']) ? $_GET['id'] : null;
        $recettes = getRecettes($id, $pdo);

        $response = [
            'success' => true,
            'content' => $recettes,
        ];
        break;

    // ========================================
    // POST : ajouter une nouvelle recette
    // Champs requis : nom, pays, difficulte, detail
    // ========================================
    case 'POST':

        // -- Vérification de la présence de tous les champs --
        if (
            !empty($_POST['nom'])        &&
            !empty($_POST['pays'])       &&
            isset($_POST['difficulte'])  &&
            is_numeric($_POST['difficulte']) &&
            !empty($_POST['detail'])
        ) {
            $nom        = trim($_POST['nom']);
            $pays       = trim($_POST['pays']);
            $difficulte = (int) $_POST['difficulte'];
            $detail     = trim($_POST['detail']);

            // -- Validation du champ nom --
            if (strlen($nom) > 50) {
                $response = [
                    'success' => false,
                    'content' => 'Le nom doit être une chaîne de 50 caractères ou moins',
                ];

            // -- Validation du champ pays --
            } elseif (strlen($pays) > 50) {
                $response = [
                    'success' => false,
                    'content' => 'Le pays doit être une chaîne de 50 caractères ou moins',
                ];

            // -- Validation du champ difficulte --
            } elseif ($difficulte < 0 || $difficulte > 5) {
                $response = [
                    'success' => false,
                    'content' => 'La difficulté doit être un entier entre 0 et 5',
                ];

            } else {
                // -- Insertion en base de données --
                postRecettes($nom, $pays, $difficulte, $detail, $pdo);

                $response = [
                    'success' => true,
                    'content' => 'Recette ajoutée avec succès',
                ];
            }

        } else {
            // -- Champs manquants --
            $response = [
                'success' => false,
                'content' => 'Informations manquantes : nom, pays, difficulte et detail sont requis',
            ];
        }
        break;

    // ========================================
    // Méthode non supportée
    // ========================================
    default:
        header('HTTP/1.0 405 Method Not Allowed');
        $response = [
            'success' => false,
            'content' => 'Méthode non autorisée. Utilisez GET ou POST.',
        ];
        break;
}

// ============================================
// ENVOI DE LA RÉPONSE EN JSON
// ============================================

if (!empty($response)) {
    header('Content-Type: application/json');
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
