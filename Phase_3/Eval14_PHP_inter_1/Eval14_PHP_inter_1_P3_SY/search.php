<?php
require 'config/db.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>

<h2>Recherche de ville</h2>

<form method="post">
    <input type="text" name="ville" placeholder="Rechercher une ville" required>
    <button>Rechercher</button>
</form>

<hr>

<h3>Vos recherches précédentes :</h3>

<?php
$sql = "SELECT villes.nom, villes.ville_id
        FROM search
        JOIN villes ON search.ville_id = villes.ville_id
        WHERE search.user_id = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);

while($row = $stmt->fetch()){
    echo '<a href="search.php?id='.$row['ville_id'].'">'.$row['nom'].'</a><br>';
}

echo "<hr>";

/* 🔎 Recherche via formulaire */
if(isset($_POST['ville'])){
    $sql = "SELECT * FROM villes WHERE nom LIKE ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["%".$_POST['ville']."%"]);
    $ville = $stmt->fetch();

    if($ville){
        echo "<h2>{$ville['nom']}</h2>";
        echo "Pays : {$ville['pays']}<br>";
        echo "Population : {$ville['population']}<br>";

        // Éviter doublons
        $check = $pdo->prepare("SELECT * FROM search WHERE user_id=? AND ville_id=?");
        $check->execute([$_SESSION['user_id'], $ville['ville_id']]);

        if(!$check->fetch()){
            $pdo->prepare("INSERT INTO search (user_id, ville_id) VALUES (?,?)")
                ->execute([$_SESSION['user_id'], $ville['ville_id']]);
        }

    } else {
        echo "Aucun résultat.";
    }
}

/* 🔗 Affichage via lien historique */
if(isset($_GET['id'])){
    $sql = "SELECT * FROM villes WHERE ville_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_GET['id']]);
    $ville = $stmt->fetch();

    if($ville){
        echo "<h2>{$ville['nom']}</h2>";
        echo "Pays : {$ville['pays']}<br>";
        echo "Population : {$ville['population']}<br>";

        // Éviter doublons
        $check = $pdo->prepare("SELECT * FROM search WHERE user_id=? AND ville_id=?");
        $check->execute([$_SESSION['user_id'], $_GET['id']]);

        if(!$check->fetch()){
            $pdo->prepare("INSERT INTO search (user_id, ville_id) VALUES (?,?)")
                ->execute([$_SESSION['user_id'], $_GET['id']]);
        }
    }
}
?>
