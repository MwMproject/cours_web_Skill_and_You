<?php
declare(strict_types=1);

require_once 'config.php';

$schools = ['École A', 'École B', 'École C'];
$sports = ['boxe', 'judo', 'football', 'natation', 'cyclisme'];

$firstnames = [
    'Lucas', 'Emma', 'Hugo', 'Léa', 'Noah', 'Chloé', 'Louis', 'Inès',
    'Nathan', 'Jade', 'Gabriel', 'Manon', 'Raphaël', 'Camille', 'Arthur',
    'Sarah', 'Tom', 'Zoé', 'Adam', 'Lina', 'Nolan', 'Eva', 'Mathis', 'Mila'
];

$lastnames = [
    'Martin', 'Bernard', 'Dubois', 'Thomas', 'Robert', 'Richard',
    'Petit', 'Durand', 'Leroy', 'Moreau', 'Simon', 'Laurent',
    'Lefebvre', 'Michel', 'Garcia', 'David', 'Bertrand', 'Roux'
];

try {
    $pdo->beginTransaction();

    $pdo->exec('DELETE FROM student_sport');
    $pdo->exec('DELETE FROM students');
    $pdo->exec('DELETE FROM sports');
    $pdo->exec('DELETE FROM schools');

    // Réinitialisation des auto-increments.
    $pdo->exec('ALTER TABLE schools AUTO_INCREMENT = 1');
    $pdo->exec('ALTER TABLE sports AUTO_INCREMENT = 1');
    $pdo->exec('ALTER TABLE students AUTO_INCREMENT = 1');

    $insertSchool = $pdo->prepare('INSERT INTO schools (name) VALUES (:name)');
    foreach ($schools as $school) {
        $insertSchool->execute(['name' => $school]);
    }

    $insertSport = $pdo->prepare('INSERT INTO sports (name) VALUES (:name)');
    foreach ($sports as $sport) {
        $insertSport->execute(['name' => $sport]);
    }

    $schoolIds = $pdo->query('SELECT id FROM schools')->fetchAll(PDO::FETCH_COLUMN);
    $sportIds = $pdo->query('SELECT id FROM sports')->fetchAll(PDO::FETCH_COLUMN);

    $insertStudent = $pdo->prepare(
        'INSERT INTO students (firstname, lastname, school_id)
         VALUES (:firstname, :lastname, :school_id)'
    );

    $insertStudentSport = $pdo->prepare(
        'INSERT INTO student_sport (student_id, sport_id)
         VALUES (:student_id, :sport_id)'
    );

    foreach ($schoolIds as $schoolId) {
        // Nombre d'élèves variable selon l'école.
        $studentsCount = random_int(10, 30);

        for ($i = 1; $i <= $studentsCount; $i++) {
            $firstname = $firstnames[array_rand($firstnames)];
            $lastname = $lastnames[array_rand($lastnames)];

            $insertStudent->execute([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'school_id' => $schoolId,
            ]);

            $studentId = (int) $pdo->lastInsertId();

            // Un élève peut avoir 0, 1, 2 ou 3 sports maximum.
            $sportsCount = random_int(0, 3);

            if ($sportsCount > 0) {
                $availableSports = $sportIds;
                shuffle($availableSports);
                $selectedSports = array_slice($availableSports, 0, $sportsCount);

                foreach ($selectedSports as $sportId) {
                    $insertStudentSport->execute([
                        'student_id' => $studentId,
                        'sport_id' => $sportId,
                    ]);
                }
            }
        }
    }

    $pdo->commit();

    header('Location: index.php?generated=1');
    exit;
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    die('Erreur pendant la génération : ' . htmlspecialchars($e->getMessage()));
}
