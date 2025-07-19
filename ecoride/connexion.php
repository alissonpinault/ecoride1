<?php include('utiles/db.php'); include('utiles/header.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        echo "<p>✅ Bienvenue, " . htmlspecialchars($user['pseudo']) . " !</p>";
    } else {
        echo "<p>❌ Identifiants incorrects</p>";
    }
}
?>

<h2>Connexion</h2>
<form method="POST">
    <label>Email : <input type="email" name="email" required></label><br>
    <label>Mot de passe : <input type="password" name="password" required></label><br>
    <button type="submit">Se connecter</button>
</form>

<?php include('utiles/footer.php'); ?>
