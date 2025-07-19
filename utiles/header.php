<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>EcoRide</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
    <h1>🌱 EcoRide</h1>
    <nav>
        <a href="index.php">Accueil</a> |
        <a href="register.php">Créer un compte</a> |
        <a href="login.php">Connexion</a> |
        <?php if (isset($_SESSION['user'])): ?>
            <a href="logout.php">Déconnexion</a>
        <?php endif; ?>
    </nav>
</header>
<main>
