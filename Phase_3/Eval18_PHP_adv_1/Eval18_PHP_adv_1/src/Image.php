<?php

class Image {

    // Extrait le nom de la série depuis le nom du fichier
    // Ex: "montagne_2009-001.jpg" → "montagne_2009"
    public function nameSubdir($name) {
        // On coupe le nom sur le tiret pour récupérer la partie gauche
        $parts = explode('-', $name);
        return $parts[0];
    }
    // Crée les sous-répertoires pour chaque série
    public function createSubdir($image_dir, $subdir_list) {
        // On supprime les doublons (si plusieurs images d'une même série)
        $subdirs = array_unique($subdir_list);
        foreach ($subdirs as $subdir) {
            // On vérifie que le dossier n'existe pas déjà avant de le créer
            if(!is_dir($image_dir . $subdir)) {
                mkdir($image_dir . $subdir, 0755);
            }
        }
        return $subdirs;
    }
    // Déplace chaque image dans le sous-répertoire de sa série
    public function moveImage($image_dir, $image_list, $subdir_list) {
        foreach ($image_list as $image) {
            // On récupère le nom de la série de cette image
            $serie = $this->nameSubdir($image);
            // On vérifie que la série existe bien dans la liste et que le dossier est prêt pour recevoir l'image
            if (in_array($serie, $subdir_list)) {
                if(is_dir($image_dir . $serie .'/')) {
                    // On déplace l'image vers son dossier de série
                    rename($image_dir . $image, $image_dir . $serie . '/' . $image);
                }
            }
        }
    }
    // Parcourt le répertoire et retourne la liste des images et des séries
    public function parseDir($image_dir) {
        if ($handle = opendir($image_dir)) {
            while (false !== ($file = readdir($handle))) {
                // On ignore les entrées "." et ".."
                if ($file != "." AND $file != "..") {
                    if(is_file($image_dir . $file)) {
                        // On ne garde que les fichiers .jpg
                        if(pathinfo($file, PATHINFO_EXTENSION) === 'jpg') {
                            $image_list[] = $file;
                            // On extrait le nom de la série et on l'ajoute à la liste
                            $subdir_list[] = $this->nameSubdir($file);
                        }
                    }
                }
            }
            closedir($handle);
        }

        // Si aucune image trouvée, on retourne null
        if(!isset($image_list)) {
            $image_list = null;
            $subdir_list = null;
        }

        return ['image_list' => $image_list , 'subdir_list' => $subdir_list];
    }
}
