<?php
require 'config/db.php';

echo "<h2>Votre panier</h2>";

$total = 0;
// Vérifie si panier existe
if(isset($_COOKIE['panier'])){
    $ids = explode(",", $_COOKIE['panier']);

    // Récupère les info de chaque produit dans le panier et calcule le total
    foreach($ids as $id){
        $stmt = $pdo->prepare("SELECT * FROM produits WHERE id = ?");
        $stmt->execute([$id]);
        $p = $stmt->fetch();

        if($p){
            echo $p['nom']." - ".$p['prix']." francs<br>";
            $total += $p['prix'];
        }
    }

    echo "<hr>Total : ".$total." francs";
} 
// Sinon affiche "panier vide"
else {
    echo "Panier vide.";
}
?>

<a href="index.php">Retour au catalogue</a>
