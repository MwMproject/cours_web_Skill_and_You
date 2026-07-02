<?php

// Connexion à la base de données en PDO
$pdo = new PDO('mysql:host=localhost;dbname=recettes_api', 'root', '');

function postRecettes($nom, $pays, $difficulte, $detail) {

	// Préparons la requête d'insertion
	$sql = "INSERT INTO recettes (nom, pays, difficulte, detail) VALUES (:nom, :pays, :difficulte, :detail)";
	global $pdo;
	$request = $pdo->prepare($sql);

	// Ajoutons les paramètres variables dans la requête
	$request->bindParam(':nom', $nom);
	$request->bindParam(':pays', $pays);
	$request->bindParam(':difficulte', $difficulte);
	$request->bindParam(':detail', $detail);

	// Exécutons la requête
	$request->execute();

}

function getRecettes($id) {
	global $pdo;

	if(is_numeric($id)) {
		// Si un $id est présent et est une valeur numérique, alors préparons la requête pour récupérer la recette demandée
		$sql = "SELECT id, nom, pays, difficulte, detail FROM recettes WHERE id = :id";
		$request = $pdo->prepare($sql);

		// Ajoutons le paramètre $id dans la requête
		$request->bindParam(':id', $id);
	}
	else {
		// Sinon, préparons la requête pour récupérer tous les recettes
		$sql = "SELECT id, nom, pays, difficulte, detail FROM recettes";
		$request = $pdo->prepare($sql);
	}

	// Exécutons la requête
	$request->execute();

	// Créons et alimentons le tableau $recettes avec les résultats de la requête
	$recettes = array();
	while($recette = $request->fetch(PDO::FETCH_ASSOC)) {

		// Chaque recette récupérée est ajoutée au tableau
		$recettes[] = $recette;
	}

	// Le résultat de la fonction est la liste des recettes récupérés
	return $recettes;

}

// $_SERVER["REQUEST_METHOD"] = "GET";
// $_GET["id"] = "";

// Contrôleur : identifions la méthode utilisée par la requête HTTP
switch($_SERVER["REQUEST_METHOD"])
{

	case 'GET':

		// Appelons la fonction de récupération avec l'id demandé s'il existe, sinon avec null
		if(!empty($_GET["id"]))
			$recettes = getRecettes($_GET["id"]);
		else
			$recettes = getRecettes(null);

		// Préparons une réponse contenant le tableau des recettes récupérées
		$response = [
			'success' => true,
			'content' => $recettes,
		];
		break;

	case 'POST':

		// Vérifions que toutes les informations requises sont bien présentes
		if(!empty($_POST["nom"]) && !empty($_POST["pays"]) && !empty($_POST["difficulte"]) && is_numeric($_POST["difficulte"]) && !empty($_POST["detail"]))
		{

			// Vérifions que les types de données envoyées soient valides
			if(!is_string($_POST["nom"]) || strlen($_POST["nom"]) > 50) {
				$response = [
					'success' => false,
					'content' => "Le nom doit être une chaîne de 50 caractères ou moins",
				];
			}
			elseif(!is_string($_POST["pays"]) || strlen($_POST["pays"]) > 50) {
				$response = [
					'success' => false,
					'content' => "Le pays doit être une chaîne de 50 caractères ou moins",
				];
			}
			elseif(!is_int($_POST["difficulte"]) || $_POST["difficulte"] < 0 || $_POST["difficulte"] > 5) {
				$response = [
					'success' => false,
					'content' => "La difficulté doit être un chiffre entre 0 et 5",
				];
			}
			else {
				// Appelons la fonction d'ajout dans la base
				postRecettes($_POST["nom"], $_POST["pays"], $_POST["difficulte"], $_POST["detail"]);

				// Préparons une réponse annonçant le succès de l'enregistrement
				$response = [
					'success' => true,
					'content' => "Recette ajoutée",
				];
			}
			
		}
		else {
			// Préparons une réponse annonçant que des données sont manquantes
			$response = [
				'success' => false,
				'content' => "Informations manquantes : nom, pays, difficulte et detail sont requis",
			];
		}
		break;

	default:
		// Requête invalide
		header("HTTP/1.0 405 Method Not Allowed");
		break;
}

// Une réponse est-elle prête ?
if(!empty($response)) {

	// Le header précise notre format de contenu
	header('Content-Type: application/json');

	// Nous encodons notre réponse en JSON
    echo json_encode($response);
}