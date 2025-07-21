<?php
session_start();
include('utiles/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        header('Location: mon_espace.php');
        exit();
    } else {
        $error = "❌ Identifiants incorrects";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion - ÉcoRide</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">
  <link rel="stylesheet" href="utiles/style.css">
</head>
<body>

 <?php include('utiles/header.php'); ?>

  <div class="presentation">
    <h1>Connexion</h1>
  </div>

  <?php if (isset($message)): ?>
    <p class="message"><?= $message ?></p>
  <?php endif; ?>

  <form method="POST" action="connexion.php">
    <label>Email :<br>
      <input type="email" name="email" required>
    </label><br>
    <label>Mot de passe :<br>
      <input type="password" name="password" required>
    </label><br>
    <button type="submit">Se connecter</button><br><br>
    <a href="creation_compte.php">S'inscrire</a>
  </form>

   <?php include('utiles/footer.php'); ?>


</body>
</html>
