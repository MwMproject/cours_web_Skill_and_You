<?php
require 'config/db.php';

// ----- Création ou récupération du panier -----
if (!isset($_COOKIE['panier_id'])) {

    // Création du panier en base
    $pdo->exec("INSERT INTO paniers (created_at) VALUES (NOW())");
    $panier_id = $pdo->lastInsertId();

    // Cookie valable 15 jours
    setcookie("panier_id", $panier_id, time() + (15*24*60*60));

} else {
    $panier_id = $_COOKIE['panier_id'];
}

// ----- Ajouter au panier -----
if (isset($_GET['add'])) {

    $produit_id = (int) $_GET['add'];

    // Vérifie si produit déjà dans panier
    $stmt = $pdo->prepare("
        SELECT id, quantite 
        FROM panier_items 
        WHERE panier_id = ? AND produit_id = ?
    ");
    $stmt->execute([$panier_id, $produit_id]);
    $item = $stmt->fetch();

    if ($item) {
        // Augmente quantité
        $stmt = $pdo->prepare("
            UPDATE panier_items 
            SET quantite = quantite + 1 
            WHERE id = ?
        ");
        $stmt->execute([$item['id']]);
    } else {
        // Insère nouveau produit
        $stmt = $pdo->prepare("
            INSERT INTO panier_items (panier_id, produit_id, quantite)
            VALUES (?, ?, 1)
        ");
        $stmt->execute([$panier_id, $produit_id]);
    }

    header("Location: index.php");
    exit;
}

// ----- Récupère catalogue -----
$stmt = $pdo->query("SELECT * FROM produits");
?>

<h2>Catalogue</h2>

<?php while ($p = $stmt->fetch()) { ?>
    <p>
        <?= htmlspecialchars($p['nom']) ?> - <?= $p['prix'] ?> francs
        <a href="index.php?add=<?= $p['id'] ?>">Ajouter au panier</a>
    </p>
<?php } ?>

<a href="panier.php">Voir le panier</a>
