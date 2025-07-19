<?php
session_start();
include('utiles/db.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ÉcoRide - Recherche</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">
  <link rel="stylesheet" href="utiles/style.css">
</head>

<body>
<?php include('utiles/header.php'); ?>
  

  <!-- Présentation -->
  <div class="presentation">
    <h2>🔍 Rechercher un covoiturage</h2>
  </div>

  <!-- Formulaire -->
  <main class="p-8 grid gap-8">
    <section class="bg-white rounded-2xl shadow-lg p-6">
      <h2 class="text-2xl font-semibold mb-4">Recherchez un trajet électrique près de chez vous</h2>
      <form action="recherche.php" method="GET" class="grid grid-cols-1 gap-4">
        <input type="text" name="ville_depart" placeholder="Lieu de départ" class="p-2 rounded-md border" required>
        <input type="text" name="ville_arrivee" placeholder="Lieu d'arrivée" class="p-2 rounded-md border" required>
        <input type="date" name="date" class="p-2 rounded-md border" required>
      </form>
    

    <!-- Filtres -->
    <label>
      <input type="checkbox" name="filtre_eco" value="1">
      Trajet écologique uniquement
    </label><br>
    <input type="number" name="filtre_prix" placeholder="Prix maximum (€)" min="0"><br>
    <input type="number" name="filtre_duree" placeholder="Durée maximum (minutes)" min="1"><br><br>

    <button type="submit">Rechercher</button>
  </form>
 </section>
  </main>
  <!-- Résultats -->
  <div class="results">
    <?php
    if (!empty($_GET['ville_depart']) && !empty($_GET['ville_arrivee']) && !empty($_GET['date'])) {
        $vd = $_GET['ville_depart'];
        $va = $_GET['ville_arrivee'];
        $date = $_GET['date'];

        $filtre_eco = isset($_GET['filtre_eco']) ? 1 : null;
        $filtre_prix = !empty($_GET['filtre_prix']) ? (float) $_GET['filtre_prix'] : null;
        $filtre_duree = !empty($_GET['filtre_duree']) ? (int) $_GET['filtre_duree'] : null;

        $sql = "SELECT c.*, u.pseudo 
                FROM covoiturages c
                JOIN users u ON u.id = c.conducteur_id
                WHERE ville_depart = ? AND ville_arrivee = ? AND date_depart = ? AND nb_places > 0";

        $params = [$vd, $va, $date];

        if ($filtre_eco !== null) {
            $sql .= " AND est_ecologique = 1";
        }

        if ($filtre_prix !== null) {
            $sql .= " AND prix <= ?";
            $params[] = $filtre_prix;
        }

        if ($filtre_duree !== null) {
            $sql .= " AND duree <= ?";
            $params[] = $filtre_duree;
        }

        $sql .= " ORDER BY heure_depart ASC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $trajets = $stmt->fetchAll();

        if ($trajets) {
            foreach ($trajets as $trajet) {
                echo "<div class='result-item" . ($trajet['est_ecologique'] ? " eco" : "") . "'>";
                echo "<strong>Conducteur :</strong> " . htmlspecialchars($trajet['pseudo']) . "<br>";
                echo "<strong>Départ :</strong> " . htmlspecialchars($trajet['ville_depart']) . " à " . $trajet['heure_depart'] . "<br>";
                echo "<strong>Arrivée :</strong> " . htmlspecialchars($trajet['ville_arrivee']) . "<br>";
                echo "<strong>Prix :</strong> " . $trajet['prix'] . " €<br>";
                echo "<strong>Durée :</strong> " . $trajet['duree'] . " min<br>";
                echo "<strong>Places restantes :</strong> " . $trajet['nb_places'] . "<br>";
                echo "<strong>Écologique :</strong> " . ($trajet['est_ecologique'] ? "✅ Oui" : "❌ Non") . "<br>";
                echo "<a href='detail.php?id=" . $trajet['id'] . "'>Voir détail</a>";
                echo "</div>";
            }
        } else {
            echo "<p style='text-align:center;'>Aucun covoiturage trouvé avec ces critères.</p>";
        }
    }
    ?>
  </div>

    <?php include('utiles/footer.php'); ?>


</body>
</html>
