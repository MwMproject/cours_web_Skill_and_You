<?php
require 'config/db.php';

echo "<h2>Votre panier</h2>";

if (!isset($_COOKIE['panier_id'])) {
    echo "Panier vide.";
} else {

    $panier_id = $_COOKIE['panier_id'];

    $stmt = $pdo->prepare("
        SELECT p.nom, p.prix, pi.quantite
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
                 " - " . $item['prix'] . 
                 " francs x " . $item['quantite'] . "<br>";

            $total += $sous_total;
        }

        echo "<hr>Total : " . $total . " francs";
    }
}
?>

<br>
<a href="index.php">Retour au catalogue</a>
