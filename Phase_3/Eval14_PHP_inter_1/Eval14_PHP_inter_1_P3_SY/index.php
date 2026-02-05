<?php
// Connexion à la base de données + la session
require 'config/db.php'; 

// Si l'utilisateur n'est pas connecté, retour au login
if($_POST){
    // Préparation de la requête pour récupérer l'utilisateur par son username
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch(); // On récupère les données de l'utilisateur

    // Si l'utilisateur existe ET que le mot de passe correspond
    // On stocke l'utilisateur en session et on le redirige vers la page de recherche
    // Sinon on affiche un message d'erreur
    if($user && password_verify($_POST['password'], $user['password'])){
        $_SESSION['user_id'] = $user['user_id'];
        header("Location: search.php");
        exit;
    } else {
        echo "Identifiants incorrects";
    }
}
?>

<h2>Connexion</h2>

<!-- Formulaire de connexion -->
<form method="post">
    <input name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button>Login</button>
</form>
