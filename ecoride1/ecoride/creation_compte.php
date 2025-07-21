<?php include('utiles/db.php'); include('utiles/header.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (pseudo, email, password) VALUES (?, ?, ?)");
    try {
        $stmt->execute([$pseudo, $email, $password]);
        echo "<p>✅ Compte créé avec succès !</p>";
    } catch (PDOException $e) {
        echo "<p>❌ Erreur : " . $e->getMessage() . "</p>";
    }
}
?>

<h2>Créer un compte</h2>
<form method="POST">
    <label>Pseudo : <input type="text" name="pseudo" required></label><br>
    <label>Email : <input type="email" name="email" required></label><br>
    <label>Mot de passe : <input type="password" name="password" required></label><br>
    <button type="submit">S’inscrire</button>
</form>

<?php include('utiles/footer.php'); ?>
