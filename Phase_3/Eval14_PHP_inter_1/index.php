<?php require 'config/db.php';

if($_POST){
  $sql = "SELECT * FROM users WHERE username = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$_POST['username']]);
  $user = $stmt->fetch();

  if($user && password_verify($_POST['password'], $user['password'])){
      $_SESSION['user_id'] = $user['user_id'];
      header("Location: index.php");
      exit;
  }
}
?>

<form method="post">
  <input name="username" placeholder="Username">
  <input type="password" name="password" placeholder="Password">
  <button>Login</button>
</form>
