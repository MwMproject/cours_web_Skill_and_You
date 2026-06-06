<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking<?= isset($pageTitle) ? ' – ' . htmlspecialchars($pageTitle) : '' ?></title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            color: #222;
        }

        /* ---- HEADER ---- */
        header {
            background: #222;
            color: white;
            padding: 20px 40px;
        }

        header h1 {
            font-size: 1.6rem;
            letter-spacing: 1px;
        }

        /* ---- NAV ---- */
        nav {
            background: #444;
            padding: 0 40px;
        }

        nav a {
            display: inline-block;
            color: white;
            text-decoration: none;
            padding: 14px 18px;
            font-size: 0.95rem;
            transition: background 0.2s;
        }

        nav a:hover,
        nav a.active {
            background: #222;
        }

        /* ---- CONTENU ---- */
        main {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* ---- FOOTER ---- */
        footer {
            text-align: center;
            padding: 20px;
            margin-top: 60px;
            font-size: 0.85rem;
            color: #888;
            border-top: 1px solid #ddd;
        }

        /* ---- UTILITAIRES ---- */
        .card {
            background: white;
            border-radius: 6px;
            padding: 24px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #222;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.2s;
        }

        .btn:hover { background: #444; }

        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 14px 18px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .alert-error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 14px 18px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        /* ---- FORMULAIRE ---- */
        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            font-size: 0.95rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #222;
        }

        /* ---- TABLE ---- */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px 14px;
            text-align: left;
        }

        th { background: #eee; }
        tr:hover { background: #fafafa; }
    </style>
</head>
<body>

<header>
    <h1>Booking</h1>
</header>

<nav>
    <a href="index.php" <?= ($currentPage ?? '') === 'home'      ? 'class="active"' : '' ?>>Accueil</a>
    <a href="index.php?page=hotels" <?= ($currentPage ?? '') === 'hotels'   ? 'class="active"' : '' ?>>Hôtels</a>
    <a href="index.php?page=reservation" <?= ($currentPage ?? '') === 'reservation' ? 'class="active"' : '' ?>>Réserver</a>
</nav>

<main>
    <?php require $view; ?>
</main>

<footer>
    &copy; <?= date('Y') ?> Booking — Application PHP Expert
</footer>

</body>
</html>
