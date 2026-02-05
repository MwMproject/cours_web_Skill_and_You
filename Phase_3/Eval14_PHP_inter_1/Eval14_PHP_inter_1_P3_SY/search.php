<?php require 'config/db.php';
if(!isset($_SESSION['user_id'])) header("Location: login.php");

// Recherche via formulaire
if(isset($_POST['ville'])){
    $sql = "SELECT * FROM villes WHERE nom LIKE ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['ville']]);
    $ville = $stmt->fetch();

    if($ville){
        // ENREGISTRER la recherche
        $sql = "INSERT INTO search (user_id, ville_id) VALUES (?,?)";
        $pdo->prepare($sql)->execute([$_SESSION['user_id'], $ville['ville_id']]);

        echo "<h2>{$ville['nom']}</h2>";
        echo "Pays : {$ville['pays']}<br>";
        echo "Population : {$ville['population']}";
    } else {
        echo "Aucun résultat.";
    }
}

// Affichage via lien
if(isset($_GET['id'])){
    $sql = "SELECT * FROM villes WHERE ville_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_GET['id']]);
    $ville = $stmt->fetch();

    echo "<h2>{$ville['nom']}</h2>";
    echo "Pays : {$ville['pays']}<br>";
    echo "Population : {$ville['population']}";
}
?>
