# ÉcoRide

ÉcoRide est une application web de covoiturage écologique, visant à favoriser la mobilité durable entre particuliers en s'appuyant sur les modèles de voiture électrique. Elle permet à des utilisateurs de proposer ou réserver des trajets, d’évaluer les conducteurs, et aux employés de modérer les avis ou signalements.

---

## Fonctionnalités principales

- Inscription / Connexion utilisateur
- Création et gestion de trajets en tant que conducteur
- Réservation de trajets en tant que passager
- Système d’avis sur les conducteurs et passagers
- Espace employé : validation des avis, gestion des signalements
- Statistiques administratives (crédits, trajets, revenus)
- Interface utilisateur responsive (desktop & mobile)


## Technologies utilisées

- **Front-end** : HTML, CSS, Tailwind CSS, JavaScript
- **Back-end** : PHP (PDO)
- **Base de données** : MySQL
- **Autres outils** : phpMyAdmin, GitHub, Font Awesome


## Structure du projet

```bash
ecoride/
├── css/
├── js/
├── utiles/
├── img/
├── pages/                # Fichiers PHP
├── fichiers_sql/
│   ├── ecoride_structure.sql
│   └── ecoride_donnees.sql
├── README.md
├── index.php
└── .htaccess



## 1. Installation et exécution en local

1. Pré-requis
- XAMPP ou tout autre environnement LAMP/WAMP

- Navigateur web

- Git (optionnel)

- phpMyAdmin

## 2. Cloner le projet
bash
Copier
Modifier
git clone https://github.com/alissonpinault/ecoride1.git

## 3. Démarrer les services
- Lancer Apache et MySQL depuis XAMPP

## 4. Configuration base de données
- Ouvrir phpMyAdmin

- Créer une base de données nommée ecoride

- Importer le fichier fichiers_sql/ecoride_structure.sql

- Importer le fichier fichiers_sql/ecoride_donnees.sql

## 5. Configurer le fichier db.php
- php
- Copier
- Modifier
$host = 'localhost';
$dbname = 'ecoride';
$username = 'root';
$password = '';

## 6. Lancer l'application
Ouvrir un navigateur et accéder à http://localhost/ecoride1

## Identifiants de test
Rôle	Email	Mot de passe
Utilisateur	test@ecoride.fr	test123
Employé	employe@ecoride.fr	employe123
Admin	admin@ecoride.fr	admin123

Ces identifiants sont présents dans la base de données fournie.

## Liens utiles

- Maquettes Figma

- Tableau de gestion projet (Notion)

