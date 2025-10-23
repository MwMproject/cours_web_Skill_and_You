<?php
if (isset($_POST['note'])) { // Vérifie si une note est envoyée
    $note = $_POST['note']; // Récupère la valeur de la note

    $correspondance = [
        "do" => "C",
        "ré" => "D",
        "mi" => "E",
        "fa" => "F",
        "sol" => "G",
        "la" => "A",
        "si" => "B"
    ];

    // Cherche si la note existe dans le tableau
    if (array_key_exists($note, $correspondance)) {
        $americain = $correspondance[$note];
        echo "La notation américaine pour la note $note est $americain.";
    } else {
        echo "Note inconnue.";
    }
} else {
    echo "Aucune note reçue.";
}
