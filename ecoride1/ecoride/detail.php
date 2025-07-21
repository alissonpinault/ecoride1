<?php
session_start();
include('utiles/db.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Identifiant de covoiturage invalide.");
}

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("SELECT c.*, u.pseudo, u.email 
                       FROM covoiturages c 
                       JOIN users u ON u.id = c.conducteur_id 
                       WHERE c.id = ?");
$stmt->execute([$id]);
$trajet = $stmt->fetch();

if (!$trajet) {
    die("Covoiturage introuvable.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Détail du covoiturage</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" href="utiles/style.css">
</head>
<body>

  <?php include('utiles/header.php'); ?>

  <div class="presentation">
    <h2>Trajet de <?= htmlspecialchars($trajet['ville_depart']) ?> → <?= htmlspecialchars($trajet['ville_arrivee']) ?></h2>
  </div>

  <div class="results">
    <div class="result-item<?= $trajet['est_ecologique'] ? ' eco' : '' ?>">
      <p><strong>Conducteur :</strong> <?= htmlspecialchars($trajet['pseudo']) ?></p>
      <p><strong>Email :</strong> <?= htmlspecialchars($trajet['email']) ?></p>
      <p><strong>Date de départ :</strong> <?= $trajet['date_depart'] ?></p>
      <p><strong>Heure de départ :</strong> <?= $trajet['heure_depart'] ?></p>
      <p><strong>Durée :</strong> <?= $trajet['duree'] ?> minutes</p>
      <p><strong>Nombre de places :</strong> <?= $trajet['nb_places'] ?></p>
      <p><strong>Prix :</strong> <?= $trajet['prix'] ?> €</p>
      <p><strong>Véhicule :</strong> <?= htmlspecialchars($trajet['vehicule']) ?></p>
      <p><strong>Écologique :</strong> <?= $trajet['est_ecologique'] ? '✅ Oui' : '❌ Non' ?></p>
    </div>
  </div>

    <?php include('utiles/footer.php'); ?>


</body>
</html>
