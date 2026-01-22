<?php
// Liste des films avec leurs titres, années et descriptions
$films = [
    [
        "titre" => "Les Évadés",
        "annee" => 1994,
        "description" => "Le banquier Andy Dufresne est arrêté pour avoir tué sa femme et son amant. Après une dure adaptation, il tente d'améliorer les conditions de la prison et de redonner de l'espoir à ses compagnons."
    ],
    [
        "titre" => "Le Parrain",
        "annee" => 1972,
        "description" => "Le patriarche vieillissant d'une dynastie de la mafia New Yorkaise passe le flambeau de son empire clandestin à son fils réticent."
    ],
    [
        "titre" => "The Dark Knight : Le Chevalier Noir",
        "annee" => 2008,
        "description" => "Lorsqu'une menace mieux connue sous le nom du Joker émerge de son passé mystérieux et déclenche le chaos sur la ville de Gotham, Batman doit faire face au plus grand des défis psychologique et physique afin de combattre l'injustice."
    ],
    [
        "titre" => "12 Hommes en colère",
        "annee" => 1957,
        "description" => "Un juré réfractaire tente d'empêcher une erreur judiciaire en forçant les autres membres du jury à réexaminer les preuves."
    ],
    [
        "titre" => "Fight Club",
        "annee" => 1999,
        "description" => "Un employé de bureau insomniaque et un fabriquant de savons forment un club de combat clandestin qui devient beaucoup plus que ça."
    ],
    [
        "titre" => "Pulp Fiction",
        "annee" => 1994,
        "description" => "Les vies de deux hommes de main, d'un boxeur, de la femme d'un gangster et de deux braqueurs s'entremêlent dans quatre histoires de violence et de rédemption."
    ]
];

$annees = [];
// Extraire les années des films
foreach ($films as $film) {
    // Ajouter l'année si elle n'est pas déjà dans la liste
    if (!in_array($film["annee"], $annees)) {
        $annees[] = $film["annee"];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche de films</title>
</head>
<body>

<h1>Recherche de films par année</h1>

<h2>Choisissez une année</h2>
<ul>
    <!-- Afficher les années disponibles -->
<?php foreach ($annees as $annee): ?>
    <li>
        <a href="index.php?annee=<?php echo $annee; ?>">
            <?php echo $annee; ?>
        </a>
    </li>
<?php endforeach; ?>
</ul>

<?php
// Vérifier si une année a été sélectionnée
if (isset($_GET["annee"])) {
    $anneeSelectionnee = $_GET["annee"];
    echo "<h2>Films de l'année $anneeSelectionnee</h2>";
    // Afficher les films correspondant à l'année sélectionnée
    foreach ($films as $film) {
        if ($film["annee"] == $anneeSelectionnee) {
            echo "<h3>" . $film["titre"] . "</h3>";
            echo "<p>" . $film["description"] . "</p>";
        }
    }
}
?>

</body>
</html>
