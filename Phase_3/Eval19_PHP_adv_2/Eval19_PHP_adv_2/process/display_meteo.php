<?php
// Ce fichier récupère les données depuis la BDD et les envoie au template
require_once(dirname(__FILE__) . '/../src/Meteo.php');
$meteo = new Meteo();

// Récupération uniquement du lendemain (06/12) et surlendemain (07/12)
$forecasts_j1 = $meteo->getMeteo(['date' => '2100-12-06', 'city' => 'Paris', 'period' => '%']);
$forecasts_j2 = $meteo->getMeteo(['date' => '2100-12-07', 'city' => 'Paris', 'period' => '%']);
// fusion des tableaux de données
$forecasts = array_merge($forecasts_j1 ?? [], $forecasts_j2 ?? []);
// Chargement du template d'affichage
$template = basename(__FILE__);
require_once("template/$template");