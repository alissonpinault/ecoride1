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
- **Autres outils** : phpMyAdmin, GitHub, Font Awesome, VS code


## Structure du projet

ecoride1/
- ecoride/
  -utiles/
            - db/
            - fonctions/
            │         ├── footer/
            │         ├── header/
            │         ├── style.css/
            ├── accueil/
            ├── connexion/
            ├── contact/
            ├── creation_compte/
            ├── deconnexion/
            ├── detail/
            ├──mentions_legales/
            ├── mon_espace/
            ├── recherche/
├── sql/
│      └── ecoride.sql
│   
├── README.md


## 1. Installation et exécution en local

1. Pré-requis
- XAMPP ou tout autre environnement LAMP/WAMP

- Navigateur web

- Git (optionnel)

- phpMyAdmin
  
- VS code

## 2. Cloner le projet
Cloner le projet dans  VS code :
git clone https://github.com/alissonpinault/ecoride1.git

## 3. Démarrer les services
- Lancer Apache et MySQL depuis XAMPP

## 4. Configuration base de données
- Ouvrir phpMyAdmin

- Créer une base de données nommée ecoride

- Importer le fichier sql/ecoride.sql

## 5. Configurer le fichier db.php
- php
- Copier
- Modifier
$host = 'localhost';
$dbname = 'ecoride1';
$username = '';
$password = '';

## 6. Lancer l'application
Ouvrir un navigateur et accéder à http://localhost/ecoride1/accueil.php

## Identifiants de test

| Rôle        | Email                                           | Mot de passe |
| ----------- | ----------------------------------------------- | ------------ |
| Utilisateur |                 marie@jeanne.com                |   ouimarie   |
| Employé     |                                                 |              |
| Admin       |                                                 |              |

Ces identifiants sont présents dans la base de données fournie.

## Liens utiles

- Maquettes Figma : https://www.figma.com/design/pjnuv0nqIrnPnbNrHkbHpZ/Untitled?node-id=0-1&m=dev&t=W7lSlEBNoXT1cr00-1

- Tableau de gestion projet : https://www.notion.so/Cr-ation-Site-Ecoride-235e2a5c21208083bdaac394ad66ed0b?source=copy_link

