<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Météo Paris</title>
    </head>
    <body>
        <?php 
        //Lecture du flux CSV et enregistrement en base de données
        require_once('process/get_meteo.php'); 
        //Récupération depuis la base de données et affichage des données
        require_once('process/display_meteo.php'); 
        ?>
    </body>
</html>