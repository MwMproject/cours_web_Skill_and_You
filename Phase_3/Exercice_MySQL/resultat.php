<?php
include("connexion.php");

// récupération de la variable externe
$recherche = '';

if (isset($_GET['recherche'])) {
    $recherche = $_GET['recherche'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Résultats</title>
</head>
<body>

<h1>Résultats de recherche</h1>

<?php

if ($recherche != '') {

    $result = $mysqli->query(
        'SELECT ville_nom FROM villes 
         WHERE ville_nom LIKE "%' . $recherche . '%"'
    );

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_array()) {
            echo $row['ville_nom'] . '<br>';
        }
    } else {
        echo "Aucune ville trouvée.";
    }

} else {
    echo "Veuillez saisir une recherche.";
}

?>

<br><br>
<a href="index.php">Retour</a>

</body>
</html>
