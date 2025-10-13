<?php
// Tableau des voyages
$travels = [
    ['departure' => 'Paris', 'arrival' => 'Nantes', 'departureTime' => '11:00', 'arrivalTime' => '12:34', 'driver' => 'Thomas'],
    ['departure' => 'Orléans', 'arrival' => 'Nantes', 'departureTime' => '05:15', 'arrivalTime' => '09:32', 'driver' => 'Mathieu'],
    ['departure' => 'Dublin', 'arrival' => 'Tours', 'departureTime' => '07:23', 'arrivalTime' => '08:50', 'driver' => 'Nathanaël'],
    ['departure' => 'Paris', 'arrival' => 'Orléans', 'departureTime' => '03:00', 'arrivalTime' => '05:26', 'driver' => 'Clément'],
    ['departure' => 'Paris', 'arrival' => 'Nice', 'departureTime' => '10:00', 'arrivalTime' => '12:09', 'driver' => 'Audrey'],
    ['departure' => 'Nice', 'arrival' => 'Nantes', 'departureTime' => '10:40', 'arrivalTime' => '13:00', 'driver' => 'Pollux'],
    ['departure' => 'Nice', 'arrival' => 'Tours', 'departureTime' => '11:00', 'arrivalTime' => '16:10', 'driver' => 'Edouard'],
    ['departure' => 'Tours', 'arrival' => 'Amboise', 'departureTime' => '16:00', 'arrivalTime' => '18:40', 'driver' => 'Priscilla'],
    ['departure' => 'Nice', 'arrival' => 'Nantes', 'departureTime' => '12:00', 'arrivalTime' => '16:00', 'driver' => 'Charlotte'],
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaire Covoiturage</title>
</head>
<body>
    <h1>Formulaire de contact - Covoiturage</h1>

    <form method="POST">
        <label>Nom : <input type="text" name="name" required></label><br><br>
        <label>Email : <input type="email" name="email" required></label><br><br>
        <label>Téléphone : <input type="tel" name="phone" required></label><br><br>

        <label>Ville de départ :
            <select name="departure" required>
                <option value="">-- Choisir une ville --</option>
                <option value="Paris">Paris</option>
                <option value="Orléans">Orléans</option>
                <option value="Dublin">Dublin</option>
                <option value="Nice">Nice</option>
                <option value="Tours">Tours</option>
            </select>
        </label><br><br>

        <button type="submit">Rechercher</button>
    </form>

    <?php
    // Affichage des trajets si le formulaire est soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $departure = $_POST['departure'];

        echo "<h2>Trajets depuis $departure :</h2>";

        $found = false;

        foreach ($travels as $travel) {
            if ($travel['departure'] === $departure) {
                echo "<p>";
                echo "Départ : {$travel['departure']} | ";
                echo "Arrivée : {$travel['arrival']} | ";
                echo "Heure départ : {$travel['departureTime']} | ";
                echo "Heure arrivée : {$travel['arrivalTime']} | ";
                echo "Conducteur : {$travel['driver']}";
                echo "</p>";
                $found = true;
            }
        }

        if (!$found) {
            echo "<p>Aucun trajet trouvé pour cette ville.</p>";
        }
    }
    ?>
</body>
</html>
