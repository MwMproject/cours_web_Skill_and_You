<?php

class Meteo {

    // Récupère le contenu du fichier CSV depuis une URL
    public function getContent($url) {
        return file_get_contents($url);
    }

    // Découpe une chaîne en tableau selon un délimiteur
    public function explodeData($data, $delimiter) {
        return explode($delimiter, $data);
    }

    // Insère une prévision en base de données
    public function insertMeteo($date, $period, $city, $resume, $resume_id, $temp_min, $temp_max, $comment) {
        // Connexion à la base
        $mysqli = new mysqli('localhost', 'root', '', 'projet_meteo');
        // Vérification de la connexion
        if ($mysqli->connect_errno) {
            echo "Echec de la connexion : $mysqli->connect_error";
            exit();
        }
        // Insertion des données dans la table meteo
        if (!$mysqli->query("INSERT INTO meteo (date, period, city, resume, resume_id, temp_min, temp_max, comment) VALUES ('$date', '$period', '$city', '$resume', $resume_id, $temp_min, $temp_max, '$comment')")) {
            echo "Une erreur est survenue lors de l'insertion des données. Message d'erreur : $mysqli->error";
            return false;
        } else {
            return true;
        }
    }

    // Récupère les prévisions depuis la base de données
    // Si $infos est vide, on récupère tout. Sinon on filtre par date, période et ville
    public function getMeteo($infos = "") {
        // Connexion à la base
        $mysqli = new mysqli('localhost', 'root', '', 'projet_meteo');
        // Vérification de la connexion
        if ($mysqli->connect_errno) {
            echo "Echec de la connexion : $mysqli->connect_error";
            exit();
        }

        if (empty($infos)) {
            // Pas de filtre : on récupère toutes les prévisions
            $sql = "SELECT * FROM meteo ORDER BY id DESC";
        } else {
            // Avec filtre : on cherche par date, période et ville
            $date = $infos['date'];
            $period = $infos['period'];
            $city = $infos['city'];
            $sql = "SELECT * FROM meteo WHERE date = '$date' AND period LIKE '$period' AND city LIKE '$city'";
        }

        $result = $mysqli->query($sql);

        if (!$result) {
            echo "Une erreur est survenue lors de la récupération des données. Message d'erreur : $mysqli->error";
            return false;
        } else {
            // On stocke chaque ligne dans un tableau
            while ($row = $result->fetch_array()) {
                $data[] = $row;
            }
            // On retourne les données si elles existent, sinon false
            if (isset($data)) {
                return $data;
            } else {
                return false;
            }
        }
    }

    // Met à jour une prévision existante en base de données
    public function updateMeteo($id, $date, $period, $city, $resume, $resume_id, $temp_min, $temp_max, $comment) {
        // Connexion à la base
        $mysqli = new mysqli('localhost', 'root', '', 'projet_meteo');
        // Vérification de la connexion
        if ($mysqli->connect_errno) {
            echo "Echec de la connexion : $mysqli->connect_error";
            exit();
        }

        // Mise à jour de la prévision identifiée par son id
        $sql = "UPDATE meteo SET date = '$date', period = '$period', city = '$city', resume = '$resume', resume_id = $resume_id, temp_min = $temp_min, temp_max = $temp_max, comment = '$comment' WHERE id = $id";

        if (!$mysqli->query($sql)) {
            echo "Une erreur est survenue lors de la mise à jour des données. Message d'erreur : $mysqli->error";
            return false;
        } else {
            return true;
        }
    }
}