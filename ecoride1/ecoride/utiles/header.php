<header>
  <img src="https://www.lignesplus-m.fr/wp-content/uploads/2023/12/covid_de_travail_ecov.webp" alt="Logo ÉcoRide" style="width: 200px; height: auto;">
  <h1>Bienvenue sur votre site de covoiturage ÉcoRide</h1>
  <p>Pour une planète plus verte</p>
</header>

<nav class="w-full bg-gray-800 text-white p-4 flex justify-around">
  <a href="accueil.php" class="flex items-center space-x-2 hover:bg-gray-700 p-2 rounded-lg">
    <i class="fas fa-home"></i>
    <span>Accueil</span>
  </a>
  <a href="recherche.php" class="flex items-center space-x-2 hover:bg-gray-700 p-2 rounded-lg">
    <i class="fas fa-car"></i>
    <span>Covoiturages</span>
  </a>
  <?php if (isset($_SESSION['user'])): ?>
    <a href="mon_espace.php" class="flex items-center space-x-2 hover:bg-gray-700 p-2 rounded-lg">
      <i class="fas fa-user"></i>
      <span>Mon espace</span>
    </a>
    <a href="deconnexion.php" class="flex items-center space-x-2 hover:bg-gray-700 p-2 rounded-lg">
      <i class="fas fa-sign-out-alt"></i>
      <span>Déconnexion</span>
    </a>
  <?php else: ?>
    <a href="connexion.php" class="flex items-center space-x-2 hover:bg-gray-700 p-2 rounded-lg">
      <i class="fas fa-sign-in-alt"></i>
      <span>Connexion</span>
    </a>
  <?php endif; ?>
  <a href="contact.php" class="flex items-center space-x-2 hover:bg-gray-700 p-2 rounded-lg">
    <i class="fas fa-envelope"></i>
    <span>Contact</span>
  </a>
</nav>
