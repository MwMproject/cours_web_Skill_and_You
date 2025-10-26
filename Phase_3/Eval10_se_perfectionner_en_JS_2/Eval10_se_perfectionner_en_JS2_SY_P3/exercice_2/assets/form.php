<?php
// Activer l'affichage des erreurs pour le débogage
error_reporting(E_ALL);
ini_set('display_errors', 1);
// form.php — génère le form + select
$notes = ["do", "ré", "mi", "fa", "sol", "la", "si"];
// Génération du formulaire HTML
echo '<form action="assets/convert.php" id="music-form">';
echo '<select name="note" id="note-select">';
echo '<option value="">-- Choisissez une note --</option>';
// Boucle pour créer les options du select
foreach ($notes as $note) {
  echo "<option value=\"$note\">$note</option>";
}
echo '</select>';
echo '</form>';
