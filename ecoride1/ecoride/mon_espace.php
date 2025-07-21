<?php
session_start();
include('utiles/db.php');

if (!isset($_SESSION['user'])) {
    header("Location: connexion.php");
    exit();
}

$user = $_SESSION['user'];
$user_id = $user['id'];

$message_success = '';
$message_error = '';

// === MISE À JOUR COMPTE ===
if (isset($_POST['update_account'])) {
    $pseudo = trim($_POST['pseudo']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($pseudo && $email) {
        if ($password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET pseudo = ?, email = ?, password = ? WHERE id = ?");
            $stmt->execute([$pseudo, $email, $hashed_password, $user_id]);
        } else {
            $stmt = $pdo->prepare("UPDATE users SET pseudo = ?, email = ? WHERE id = ?");
            $stmt->execute([$pseudo, $email, $user_id]);
        }

        $_SESSION['user']['pseudo'] = $pseudo;
        $_SESSION['user']['email'] = $email;
        $message_success = "✅ Informations du compte mises à jour.";
    } else {
        $message_error = "⚠️ Veuillez remplir tous les champs requis.";
    }
}

// === AJOUT / SUPPRESSION VÉHICULE ===
if (isset($_POST['add_vehicle'])) {
    $stmt = $pdo->prepare("INSERT INTO voiture (modele, immatriculation, energie, couleur, date_premiere_immatriculation, user_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['modele'], $_POST['immatriculation'], $_POST['energie'], $_POST['couleur'], $_POST['date_immat'], $user_id
    ]);
    $message_success = "✅ Véhicule ajouté.";
}

if (isset($_POST['delete_vehicle'])) {
   $stmt = $pdo->prepare("DELETE FROM voiture WHERE voiture_id = ? AND user_id = ?");
$stmt->execute([$_POST['voiture_id'], $user_id]);
    $message_success = "🗑️ Véhicule supprimé.";
}

// === AJOUT / SUPPRESSION COVOITURAGE ===
if (isset($_POST['add_ride'])) {
    $vehicule = $pdo->prepare("SELECT modele, immatriculation FROM voiture WHERE user_id = ? LIMIT 1");
    $vehicule->execute([$user_id]);
    $v = $vehicule->fetch();
    $vehicule_nom = $v ? $v['modele'] . ' - ' . $v['immatriculation'] : null;

    $stmt = $pdo->prepare("INSERT INTO covoiturages (user_id, ville_depart, ville_arrivee, date_depart, heure_depart, duree, nb_places, prix, vehicule, est_ecologique) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $user_id, $_POST['ville_depart'], $_POST['ville_arrivee'], $_POST['date_depart'], $_POST['heure_depart'],
        $_POST['duree'], $_POST['nb_places'], $_POST['prix'], $vehicule_nom, isset($_POST['est_ecologique']) ? 1 : 0
    ]);
    $message_success = "✅ Covoiturage ajouté.";
}

if (isset($_POST['delete_ride'])) {
    $stmt = $pdo->prepare("DELETE FROM covoiturages WHERE id = ? AND user_id = ?");
    $stmt->execute([$_POST['ride_id'], $user_id]);
    $message_success = "🗑️ Covoiturage supprimé.";
}

// === DONNÉES À AFFICHER ===
$vehicules = $pdo->prepare("SELECT * FROM voiture WHERE user_id = ?");
$vehicules->execute([$user_id]);

$my_covoiturages = $pdo->prepare("SELECT * FROM covoiturages WHERE user_id = ? ORDER BY date_depart DESC");
$my_covoiturages->execute([$user_id]);
$my_covoiturages = $my_covoiturages->fetchAll();


$user_stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$user_stmt->execute([$user_id]);
$user = $user_stmt->fetch();


// === Récupère les covoiturages réservés par l'utilisateur ===

$stmt = $pdo->prepare("
    SELECT c.*, r.date_inscription, r.statut, u.pseudo AS chauffeur
    FROM reservations r
    JOIN covoiturages c ON r.id_covoiturage = c.id
    JOIN users u ON c.user_id = u.id
    WHERE r.id_user = ?
    ORDER BY c.date_depart DESC
");

$stmt->execute([$user_id]);
$reservations = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Espace - ÉcoRide</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="utiles/style.css">
    <style>
        .tab-btn { padding: 10px 20px; border: none; cursor: pointer; font-weight: bold; border-radius: 5px; background-color: #e5e7eb; }
        .tab-btn.active { background-color: #4caf50; color: white; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
    </style>
</head>
<body>
<?php include('utiles/header.php'); ?>
<main class="presentation">
    <h1>Mon Espace</h1>

    <?php if ($message_success): ?>
        <p class="text-green-600 font-bold"><?= $message_success ?></p>
    <?php elseif ($message_error): ?>
        <p class="text-red-600 font-bold"><?= $message_error ?></p>
    <?php endif; ?>

    <!-- Onglets -->
    <div class="mb-4 flex gap-2">
        <button class="tab-btn active" onclick="switchTab('infos')">👤 Infos</button>
        <button class="tab-btn" onclick="switchTab('vehicules')">🚗 Véhicules</button>
        <button class="tab-btn" onclick="switchTab('covoiturages')">🚌 Covoiturages</button>
    </div>

    <!-- Onglet INFOS -->
    <div id="infos" class="tab-content active">
        <h2>Mes informations</h2>
        <form method="POST">
            <input type="hidden" name="update_account">
            <label>Pseudo :<br><input type="text" name="pseudo" value="<?= htmlspecialchars($user['pseudo']) ?>"></label><br>
            <label>Email :<br><input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>"></label><br>
            <label>Nouveau mot de passe :<br><input type="password" name="password" placeholder="Laisse vide pour ne pas changer"></label><br>
            <label>Rôle : <strong><?= htmlspecialchars($user['role']) ?></strong></label><br>
            <label>Crédits : <strong><?= htmlspecialchars($user['credits']) ?></strong></label><br><br>
            <button type="submit">Mettre à jour</button>
        </form>
    </div>
<div id="vehicules" class="tab-content">
    <h2>Mes véhicules</h2>

    <?php foreach ($vehicules as $v): ?>
        <div class="border p-3 mb-2">
            <strong><?= htmlspecialchars($v['modele']) ?> (<?= htmlspecialchars($v['immatriculation']) ?>)</strong><br>
            Énergie : <?= htmlspecialchars($v['energie']) ?> | Couleur : <?= htmlspecialchars($v['couleur']) ?><br>
            Immatriculé le : <?= htmlspecialchars($v['date_premiere_immatriculation']) ?><br>

            <!-- Formulaire Modifier -->
            <form method="POST" style="display:inline">
                <input type="hidden" name="update_vehicle">
                <input type="hidden" name="voiture_id" value="<?= (int)$v['voiture_id'] ?>">
                <button type="submit">Modifier</button>
            </form>

            <!-- Formulaire Supprimer -->
            <form method="POST" style="display:inline" onsubmit="return confirm('Voulez-vous vraiment supprimer ce véhicule ?');">
                <input type="hidden" name="delete_vehicle">
                <input type="hidden" name="voiture_id" value="<?= (int)$v['voiture_id'] ?>">
                <button type="submit">Supprimer</button>
            </form>
        </div>
    <?php endforeach; ?>

    <!-- Formulaire ajout véhicule -->
    <h3>Ajouter un véhicule</h3>
    <form method="POST">
        <input type="hidden" name="add_vehicle">
        <label>Modèle :<br><input type="text" name="modele" required></label><br>
        <label>Immatriculation :<br><input type="text" name="immatriculation" required></label><br>
        <label>Énergie :<br><input type="text" name="energie"></label><br>
        <label>Couleur :<br><input type="text" name="couleur"></label><br>
        <label>Date d'immatriculation :<br><input type="date" name="date_immat"></label><br>
        <button type="submit">Ajouter</button>
    </form>
</div>


    <!-- Onglet COVOITURAGES -->
  <div id="covoiturages" class="tab-content">
  <h2 class="text-xl font-bold mb-4">Mes covoiturages</h2>

  <!-- Onglets internes -->
  <div class="flex space-x-4 mb-4">
    <button onclick="showSubTab('conducteur')" class="subtab-btn bg-green-600 text-white px-4 py-2 rounded">Conducteur</button>
    <button onclick="showSubTab('passager')" class="subtab-btn bg-gray-200 text-black px-4 py-2 rounded">Passager</button>
  </div>

  <!-- Section conducteur -->
  <div id="subtab-conducteur" class="subtab-content">
    <h3 class="text-lg font-semibold mb-2">Mes trajets en tant que conducteur</h3>

    <?php if (count($my_covoiturages) > 0): ?>
      <ul class="space-y-4">
        <?php foreach ($my_covoiturages as $covoit): ?>
          <li class="border p-4 rounded bg-white shadow">
            <p><strong>Trajet :</strong> <?= htmlspecialchars($covoit['ville_depart']) ?> → <?= htmlspecialchars($covoit['ville_arrivee']) ?></p>
            <p><strong>Date :</strong> <?= date('d/m/Y', strtotime($covoit['date_depart'])) ?> à <?= date('H:i', strtotime($covoit['heure_depart'])) ?></p>
            <p><strong>Places disponibles :</strong> <?= $covoit['nb_places'] ?></p>
            <p><strong>Écologique :</strong> <?= $covoit['est_ecologique'] ? 'Oui' : 'Non' ?></p>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p class="text-gray-500">Vous n'avez pas encore proposé de covoiturages.</p>
    <?php endif; ?>

    <h3 class="mt-6 text-lg font-semibold">Ajouter un covoiturage</h3>
    <form method="POST" class="space-y-2 mt-2">
        <input type="hidden" name="add_ride">
        <label>Ville de départ :<br><input type="text" name="ville_depart" required></label><br>
        <label>Ville d’arrivée :<br><input type="text" name="ville_arrivee" required></label><br>
        <label>Date de départ :<br><input type="date" name="date_depart" required></label><br>
        <label>Heure de départ :<br><input type="time" name="heure_depart" required></label><br>
        <label>Durée (min) :<br><input type="number" name="duree" required></label><br>
        <label>Places disponibles :<br><input type="number" name="nb_places" required></label><br>
        <label>Prix (€) :<br><input type="number" step="0.01" name="prix" required></label><br>
        <label><input type="checkbox" name="est_ecologique"> Trajet écologique</label><br>
        <button type="submit">Ajouter</button>
    </form>
  </div>

  <!-- Section passager -->
  <div id="subtab-passager" class="subtab-content hidden">
    <h3 class="text-lg font-semibold mb-2">Mes réservations en tant que passager</h3>

    <?php if (count($reservations) > 0): ?>
      <ul class="space-y-4">
        <?php foreach ($reservations as $res): ?>
          <li class="border p-4 rounded bg-white shadow">
            <p><strong>Trajet :</strong> <?= htmlspecialchars($res['ville_depart']) ?> → <?= htmlspecialchars($res['ville_arrivee']) ?></p>
            <p><strong>Date :</strong> <?= date('d/m/Y', strtotime($res['date_depart'])) ?> à <?= date('H:i', strtotime($res['heure_depart'])) ?></p>
            <p><strong>Chauffeur :</strong> <?= htmlspecialchars($res['chauffeur']) ?></p>
            <p><strong>Statut :</strong> <?= htmlspecialchars($res['statut']) ?></p>
            <p class="text-sm text-gray-500">Réservé le <?= date('d/m/Y à H:i', strtotime($res['date_inscription'])) ?></p>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p class="text-gray-500">Vous n'avez pas encore réservé de covoiturage.</p>
    <?php endif; ?>
  </div>
</div>


        
    </div>
</main>

<script>
function switchTab(id) {
    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));

    document.getElementById(id).classList.add('active');

    // Met à jour le bon bouton
    document.querySelectorAll('.tab-btn').forEach(btn => {
        if (btn.getAttribute("onclick").includes(id)) {
            btn.classList.add('active');
        }
    });
}
</script>


</html>
<?php include('utiles/footer.php'); ?>