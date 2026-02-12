<?php
$mysqli = new mysqli("localhost", "root", "", "villes_db");

if ($mysqli->connect_error) {
    die("Erreur de connexion : " . $mysqli->connect_error);
}
?>