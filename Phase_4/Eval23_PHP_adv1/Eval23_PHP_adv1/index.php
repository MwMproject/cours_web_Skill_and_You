<?php
require_once 'config.php';

$schoolsQuery = $pdo->query("
    SELECT 
        sc.id,
        sc.name,
        COUNT(DISTINCT st.id) AS total_students,
        COUNT(DISTINCT ss.student_id) AS students_with_sport,
        COUNT(DISTINCT ss.sport_id) AS sports_count
    FROM schools sc
    LEFT JOIN students st ON st.school_id = sc.id
    LEFT JOIN student_sport ss ON ss.student_id = st.id
    GROUP BY sc.id, sc.name
    ORDER BY sc.name ASC
");

$schools = $schoolsQuery->fetchAll();

$sportsBySchoolQuery = $pdo->prepare("
    SELECT 
        sp.name,
        COUNT(ss.student_id) AS total
    FROM sports sp
    JOIN student_sport ss ON ss.sport_id = sp.id
    JOIN students st ON st.id = ss.student_id
    WHERE st.school_id = :school_id
    GROUP BY sp.id, sp.name
    ORDER BY total ASC, sp.name ASC
");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Génération de contenus et statistiques</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f5f5;
        }

        h1 {
            color: #222;
        }

        .button {
            display: inline-block;
            padding: 10px 16px;
            background: #222;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .success {
            background: #d4edda;
            padding: 12px;
            border: 1px solid #c3e6cb;
            color: #155724;
            margin-bottom: 20px;
        }

        .school {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background: #eee;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Génération de contenus et statistiques</h1>

    <a class="button" href="generate.php">Générer aléatoirement les données</a>

    <?php if (isset($_GET['generated'])): ?>
        <div class="success">Les données ont été générées avec succès.</div>
    <?php endif; ?>

    <?php if (empty($schools)): ?>
        <p>Aucune donnée disponible. Cliquez sur le bouton pour générer les données.</p>
    <?php endif; ?>

    <?php foreach ($schools as $school): ?>
        <div class="school">
            <h2><?= htmlspecialchars($school['name']) ?></h2>

            <p><strong>Nombre d'élèves :</strong> <?= $school['total_students'] ?></p>
            <p><strong>Nombre d'élèves pratiquant au moins un sport :</strong> <?= $school['students_with_sport'] ?></p>
            <p><strong>Nombre d'activités sportives pratiquées :</strong> <?= $school['sports_count'] ?></p>

            <h3>Activités sportives pratiquées</h3>

            <?php
            $sportsBySchoolQuery->execute(['school_id' => $school['id']]);
            $sports = $sportsBySchoolQuery->fetchAll();
            ?>

            <?php if (empty($sports)): ?>
                <p>Aucune activité sportive pratiquée dans cette école.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Sport</th>
                            <th>Nombre d'élèves</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sports as $sport): ?>
                            <tr>
                                <td><?= htmlspecialchars($sport['name']) ?></td>
                                <td><?= $sport['total'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <h2>Question complémentaire</h2>
    <p>
        Une évolution fonctionnelle utile serait de créer une interface d'administration permettant
        d'ajouter, modifier ou supprimer des écoles, des élèves et des sports. Cela rendrait
        l'application plus flexible, car les données ne seraient plus limitées aux écoles et sports
        définis dans le code.
    </p>
</body>
</html>
