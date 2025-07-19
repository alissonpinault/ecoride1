<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ÉcoRide - Accueil</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">
  <link rel="stylesheet" href="utiles/style.css">
</head>
<body>

  <?php include('utiles/header.php'); ?>

  <section class="presentation">
    <h2>Qui sommes-nous ?</h2>
    <p>ÉcoRide est une entreprise engagée pour l’environnement. Nous proposons des covoiturages écologiques pour préserver notre planète.</p>
   
  </section>

  <main class="p-8 grid gap-8">
    <section class="bg-white rounded-2xl shadow-lg p-6">
      <h2 class="text-2xl font-semibold mb-4">Recherchez un trajet électrique près de chez vous</h2>
      <form action="recherche.php" method="GET" class="grid grid-cols-1 gap-4">
        <input type="text" name="ville_depart" placeholder="Lieu de départ" class="p-2 rounded-md border" required>
        <input type="text" name="ville_arrivee" placeholder="Lieu d'arrivée" class="p-2 rounded-md border" required>
        <input type="date" name="date" class="p-2 rounded-md border" required>
        <button type="submit">Rechercher</button>
      </form>
    </section>
  </main>

   <?php include('utiles/footer.php'); ?>


</body>
</html>
