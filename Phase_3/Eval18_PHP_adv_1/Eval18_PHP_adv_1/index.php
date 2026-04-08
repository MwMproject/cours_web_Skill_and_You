<?php

// Chemin absolu vers le répertoire des images
// dirname(__FILE__) retourne le dossier où se trouve ce fichier
$image_dir = dirname(__FILE__) . '/vrac/';

// On inclut la classe Image
require('class/Image.php');

// On crée un objet Image pour utiliser ses méthodes
$image = new Image();

// On parcourt le répertoire et on récupère la liste des images et des séries
$image_data = $image->parseDir($image_dir);
$subdir_list = $image_data['subdir_list'];
$image_list = $image_data['image_list'];

// Si aucune image trouvée, on affiche un message et on arrête le script
if(!isset($image_list)) {
    echo 'Aucune image dans le répertoire';
    exit;
}

// On crée les sous-répertoires pour chaque série
$subdir_list = $image->createSubdir($image_dir, $subdir_list);

// On déplace chaque image dans le sous-répertoire correspondant à sa série
$image->moveImage($image_dir, $image_list, $subdir_list);
