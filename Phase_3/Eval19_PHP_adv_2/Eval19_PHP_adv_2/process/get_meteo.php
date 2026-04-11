<?php
// On récupère les données depuis le flux et on les stocke en base de données
require_once(dirname(__FILE__) . '/../class/Meteo.php');
$url = "http://localhost/paris.csv";

$meteo = new Meteo();
// On récupère contenu du fichier CSV
$content = $meteo->getContent($url);
// On découpe le contenu ligne par ligne
$lines = $meteo->explodeData($content, "\n");
// pour chaque ligne, on crée un tableau de données
foreach ($lines as $line) {
    $infos[] = $meteo->explodeData($line, ';');
}
// On enregistre chaque ligne en base de données
// et si la donnée existe, elle est mise à jour
foreach ($infos as $info) {
    // on ignore les lignes vides (la dernière ligne du CSV est vide)
    if (!empty($info[0])) {
        // On nomme chaque colonne du CSV pour plus de clarté
        $date = $info[0];
        $city = $info[1];
        $period = $info[2];
        $resume = $info[3];
        $resume_id = $info[4];
        $temp_min = $info[5];
        $temp_max = $info[6];
        $comment = $info[7];

        // On vérifie si cette prévision existe déjà en base de données
        $forecast = ['date' => $date, 'city' => $city, 'period' => $period];
        $cityDateMeteo = $meteo->getMeteo($forecast);
        // si la donnée n'existe pas, elle est insérée
        if ($cityDateMeteo === false ) {
            $meteo->insertMeteo($date, $period, $city, $resume, $resume_id, $temp_min, $temp_max, $comment);
        } else {
            // Si la donnée existe déjà, on la met à jour
            $id = $cityDateMeteo[0]['id'];
            $meteo->updateMeteo($id, $date, $period, $city, $resume, $resume_id, $temp_min, $temp_max, $comment);
        }
    }
}

