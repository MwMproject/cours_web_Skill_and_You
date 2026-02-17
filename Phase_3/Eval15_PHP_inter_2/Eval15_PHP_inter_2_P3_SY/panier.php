<?php
require 'config/db.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Votre panier</title>
</head>
<body>

<h2>Votre panier</h2>

<?php

if (!isset($_COOKIE['panier_id'])) {
    echo "Panier vide.";
} else {

    $panier_id = $_COOKIE['panier_id'];

    // ----- Suppression d’un produit -----
    if (isset($_GET['remove'])) {

        $produit_id = (int) $_GET['remove'];

        $delete = $pdo->prepare("
            DELETE FROM panier_items
            WHERE panier_id = ? AND produit_id = ?
        ");
        $delete->execute([$panier_id, $produit_id]);

        header("Location: panier.php");
        exit;
    }

    // ----- Récupération des produits -----
    $stmt = $pdo->prepare("
        SELECT p.id, p.nom, p.prix, pi.quantite
        FROM panier_items pi
        JOIN produits p ON pi.produit_id = p.id
        WHERE pi.panier_id = ?
    ");
    $stmt->execute([$panier_id]);

    $items = $stmt->fetchAll();

    if (!$items) {
        echo "Panier vide.";
    } else {

        $total = 0;

        foreach ($items as $item) {

            $sous_total = $item['prix'] * $item['quantite'];

            echo htmlspecialchars($item['nom']) . 
                 " - " . htmlspecialchars($item['prix']) . 
                 " francs x " . htmlspecialchars($item['quantite']) . 
                 " ";

            echo '<a href="panier.php?remove=' . $item['id'] . '">Supprimer</a>';

            echo "<br>";

            $total += $sous_total;
        }

        echo "<hr>Total : " . $total . " francs";
    }
}
?>

<br>
<a href="index.php">Retour au catalogue</a>

</body>
</html>
