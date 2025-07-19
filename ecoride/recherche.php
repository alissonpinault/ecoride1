<?php include('utiles/db.php'); include('utiles/header.php'); ?>

<h2>🔍 Recherche de covoiturage</h2>

<form method="GET">
    <label>Ville de départ :
        <input type="text" name="ville_depart" required>
    </label><br>
    <label>Ville d’arrivée :
        <input type="text" name="ville_arrivee" required>
    </label><br>
    <label>Date :
        <input type="date" name="date" required>
    </label><br>
    <button type="submit">Rechercher</button>
</form>

<hr>

<?php
if (!empty($_GET['ville_depart']) && !empty($_GET['ville_arrivee']) && !empty($_GET['date'])) {
    $vd = $_GET['ville_depart'];
    $va = $_GET['ville_arrivee'];
    $date = $_GET['date'];

    $stmt = $pdo->prepare("SELECT c.*, u.pseudo, u.email 
                           FROM covoiturages c
                           JOIN users u ON u.id = c.conducteur_id
                           WHERE ville_depart = ? AND ville_arrivee = ? AND date_depart = ? AND nb_places > 0
                           ORDER BY heure_depart ASC");

    $stmt->execute([$vd, $va, $date]);
    $trajets = $stmt->fetchAll();

    if ($trajets) {
        foreach ($trajets as $trajet) {
            echo "<div style='border:1px solid #ccc; margin-bottom:15px; padding:10px'>";
            echo "<strong>Conducteur :</strong> " . htmlspecialchars($trajet['pseudo']) . "<br>";
            echo "<strong>Départ :</strong> " . htmlspecialchars($trajet['ville_depart']) . " à " . $trajet['heure_depart'] . "<br>";
            echo "<strong>Arrivée :</strong> " . htmlspecialchars($trajet['ville_arrivee']) . "<br>";
            echo "<strong>Prix :</strong> " . $trajet['prix'] . " €<br>";
            echo "<strong>Places restantes :</strong> " . $trajet['nb_places'] . "<br>";
            echo "<strong>Ecologique ?</strong> " . ($trajet['est_ecologique'] ? "✅ Oui" : "❌ Non") . "<br>";
            echo "<a href='detail.php?id=" . $trajet['id'] . "'>Voir détail</a>";
            echo "</div>";
        }
    } else {
        echo "<p>Aucun covoiturage trouvé pour ces critères.</p>";
    }
}
?>

<?php include('utiles/footer.php'); ?>
