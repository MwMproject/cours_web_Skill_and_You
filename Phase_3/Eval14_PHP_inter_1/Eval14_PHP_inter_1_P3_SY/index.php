<?php
require 'config/db.php';

if($_POST){
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch();

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
<form method="post">
    <input name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button>Login</button>
</form>
