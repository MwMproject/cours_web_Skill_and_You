<?php
// On détermine le chemin du répertoire images/
// la constante PHP __FILE__ restitue le chemin du fichier en cours
// la fonction dirname restitue le chemin du répertoire du fichier
$image_dir = dirname(__FILE__) . '/images/';
// inclusion classe Image
require('class/Image.php');
// instanciation classe Image
$image = new Image();
// parse images/ et récupérons liste des fichiers et répertoires
$image_data = $image->parseDir($image_dir);
$subdir_list = $image_data['subdir_list'];
$image_list = $image_data['image_list'];
// $image_list est 'null' si aucune image n'est présente dans le répertoire
if(!isset($image_list)) {
    echo 'Aucune image dans le répertoire';
    exit;
}
// Créons les sous-répertoires
$subdir_list = $image->createSubdir($image_dir, $subdir_list);
// puis déplaçons les images dans ces sous-répertoires
$image->moveImage($image_dir, $image_list, $subdir_list);
