<?php
// Connexion à la base de données + la session
require 'config/db.php';

// Si l'utilisateur n'est pas connecté, retour au login
if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>

<h2>Recherche de ville</h2>
<!-- Formulaire de recherche -->
<form method="post">
    <input type="text" name="ville" placeholder="Rechercher une ville" required>
    <button>Rechercher</button>
</form>
<hr>
<h3>Vos recherches précédentes :</h3>
<?php

// Requête pour récupérer l'historique des recherches de l'utilisateur connecté
$sql = "SELECT villes.nom, villes.ville_id
        FROM search
        JOIN villes ON search.ville_id = villes.ville_id
        WHERE search.user_id = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);

// Affichage des recherches sous forme de liens
while($row = $stmt->fetch()){
    echo '<a href="search.php?id='.$row['ville_id'].'">'.$row['nom'].'</a><br>';
}

echo "<hr>";

/* ---------------- RECHERCHE VIA FORMULAIRE ---------------- */

if(isset($_POST['ville'])){

    // Recherche d'une ville correspondant au texte saisi par l'utilisateur
    $sql = "SELECT * FROM villes WHERE nom LIKE ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["%".$_POST['ville']."%"]);
    $ville = $stmt->fetch();

    if($ville){
        // Affichage des infos de la ville trouvée
        echo "<h2>{$ville['nom']}</h2>";
        echo "Pays : {$ville['pays']}<br>";
        echo "Population : {$ville['population']}<br>";

        // Vérifier si cette recherche existe déjà pour éviter les doublons
        $check = $pdo->prepare("SELECT * FROM search WHERE user_id=? AND ville_id=?");
        $check->execute([$_SESSION['user_id'], $ville['ville_id']]);

        // Si la recherche n'existe pas encore, on l'enregistre
        if(!$check->fetch()){
            $pdo->prepare("INSERT INTO search (user_id, ville_id) VALUES (?,?)")
                ->execute([$_SESSION['user_id'], $ville['ville_id']]);
        }

    } else {
        echo "Aucun résultat."; // Ville non trouvée
    }
}

/* ---------------- AFFICHAGE VIA LIEN HISTORIQUE ---------------- */

if(isset($_GET['id'])){

    // On récupère la ville correspondant à l'id dans l'URL
    $sql = "SELECT * FROM villes WHERE ville_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_GET['id']]);
    $ville = $stmt->fetch();

    if($ville){
        // Affichage des informations de la ville sélectionnée
        echo "<h2>{$ville['nom']}</h2>";
        echo "Pays : {$ville['pays']}<br>";
        echo "Population : {$ville['population']}<br>";

        // Vérifier doublon avant insertion dans l'historique
        $check = $pdo->prepare("SELECT * FROM search WHERE user_id=? AND ville_id=?");
        $check->execute([$_SESSION['user_id'], $_GET['id']]);

        if(!$check->fetch()){
            $pdo->prepare("INSERT INTO search (user_id, ville_id) VALUES (?,?)")
                ->execute([$_SESSION['user_id'], $_GET['id']]);
        }
    }
}
?>
