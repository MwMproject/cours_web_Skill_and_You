<?php
require 'config/db.php';

// ----- "Ajouter au panier" -----
if(isset($_GET['add'])){
    $id = $_GET['add'];

    // Si panier déjà existant, on y ajoute le produit
    if(isset($_COOKIE['panier'])){
        $panier = $_COOKIE['panier'] . "," . $id;
    } 
    // Sinon on crée le panier
    else { 
        $panier = $id;
    }

    // Cookie(pannier) valable 15 jours
    setcookie("panier", $panier, time() + (15*24*60*60));
    header("Location: index.php");
    exit; 
}

// Récupère tous les produits du catalogue
$stmt = $pdo->query("SELECT * FROM produits");
?>

<h2>Catalogue</h2>

<?php while($p = $stmt->fetch()) { ?>
    <p>
        <?= $p['nom'] ?> - <?= $p['prix'] ?> francs
        <a href="index.php?add=<?= $p['id'] ?>">Ajouter au panier</a>
    </p>
<?php } ?>

<a href="panier.php">Voir le panier</a>
