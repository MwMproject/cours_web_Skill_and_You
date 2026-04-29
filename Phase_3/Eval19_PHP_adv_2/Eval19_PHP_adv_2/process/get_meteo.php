<?php
// On récupère les données depuis le flux et on les stocke en base de données
require_once(dirname(__FILE__) . '/../src/Meteo.php');

// Chemin direct vers le fichier CSV (plus fiable que http://localhost)
$filepath = dirname(__FILE__) . '/../paris.csv';

$meteo = new Meteo();

// On ouvre le fichier CSV avec fgetcsv() comme conseillé
$handle = fopen($filepath, 'r');

if ($handle !== false) {
    while (($info = fgetcsv($handle, 1000, ';')) !== false) {

        if (count($info) >= 8 && !empty($info[0])) {

            $date      = $info[0];
            $city      = $info[1];
            $period    = $info[2];
            $resume    = $info[3];
            $resume_id = (int) $info[4];
            $temp_min  = (int) $info[5];
            $temp_max  = (int) $info[6];
            $comment   = $info[7];

            $forecast = [
                'date' => $date,
                'city' => $city,
                'period' => $period
            ];

            $cityDateMeteo = $meteo->getMeteo($forecast);

            if ($cityDateMeteo === false) {
                $meteo->insertMeteo($date, $period, $city, $resume, $resume_id, $temp_min, $temp_max, $comment);
            } else {
                $id = $cityDateMeteo[0]['id'];
                $meteo->updateMeteo($id, $date, $period, $city, $resume, $resume_id, $temp_min, $temp_max, $comment);
            }
        }
    }
    fclose($handle);
} else {
    echo "Erreur : impossible d'ouvrir le fichier CSV.";
}