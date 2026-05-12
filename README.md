# Projet Salle - Application de reservation de salles

## Lien Utiles
- [Repo complet du guide](https://github.com/mgamsdve/GuideProjet)

- [Google Slides](https://docs.google.com/presentation/d/1oUtDvOm9PPslUE7LXXXopBRl5ctr8XTi/edit?usp=sharing&ouid=115021727874337636729&rtpof=true&sd=true)
- [Site Web](https://bookroom-wheat.vercel.app/)
- mot de passe admin : 
  ```php
   test123
  ```
- utilisateur admin : 
- ```php
   secure@demo.be
  ```

Les deux versions Google Docs des fichiers de référence sont ici :

- [Guide de démarrage](https://docs.google.com/document/d/1kcZQ4TD_iVnpl2muefRgbzKPXGCY6HY7BEIKFl5jEms/edit?usp=sharing)
- [Vue globale du projet](https://docs.google.com/document/d/10xwMY_bJuB04vr-UccYx0ge9b2Uhkl1ibRsBFgzXw4A/edit?usp=sharing)
- [Guide session](guide-session.md)
  
## À quoi sert ce repo

- `Guide-de-demarrage.md` : guide de démarrage technique pour structurer le projet, connecter la base de données et mettre en place le MVC.
- `vue-global.md` : vue d'ensemble du projet, de son architecture et de ses règles de fonctionnement.

## Structure générale

Le projet suit une organisation classique :

- `Assets/` pour les styles, images et scripts
- `Config/` pour la configuration, dont la connexion à la base de données
- `Controllers/` pour la logique de routage et de traitement
- `Models/` pour les requêtes SQL
- `Views/` pour l'affichage HTML/PHP
- `SQL/` pour les scripts de création et de remplissage de la base

  
## Démarrage rapide

1. Lire le guide de démarrage pour comprendre la structure attendue.
2. Vérifier la connexion à la base de données dans `Config/connectDatabase.php`.
3. Construire le point d'entrée `index.php` et brancher les controllers.
4. Développer ensuite les models et les views selon les besoins du projet.


Application web PHP (architecture MVC simple) pour gerer des salles, leurs equipements, et les reservations des utilisateurs.

## Sommaire

- Description
- Fonctionnalites
- Technologies
- Prerequis
- Installation
- Configuration de la base de donnees
- Lancer le projet en local
- Routes principales
- Structure du projet
- Notes

## Description

Ce projet permet de :

- consulter la liste des salles
- voir le detail d une salle (categorie, equipements, reservations)
- creer un compte et se connecter
- gerer son profil
- creer et supprimer ses reservations
- acceder a une interface d administration (selon le role)

## Fonctionnalites

### Cote utilisateur

- Inscription et connexion
- Consultation des salles
- Consultation des equipements
- Creation de reservation avec validations :
  - champs obligatoires
  - date de fin strictement apres la date de debut
  - duree maximale de 5 jours
- Consultation et suppression de ses reservations
- Modification de son profil

### Cote administrateur

- Tableau de bord admin
- Gestion CRUD de :
  - utilisateurs
  - categories
  - salles
  - equipements
  - contenances (liaison salle-equipement)
  - reservations

## Technologies

- PHP (sans framework)
- MySQL
- HTML / CSS
- PDO pour l acces base de donnees

## Prerequis

- PHP 8.x recommande
- MySQL 8.x recommande
- Un serveur local (ex: serveur integre PHP)

## Installation

1. Cloner ou copier le projet dans votre dossier local.
2. Ouvrir le dossier du projet.
3. Verifier la configuration de connexion BDD dans Config/connectDatabase.php.

Configuration actuelle :

- hote : localhost
- port : 3306
- base : sys
- utilisateur : root
- mot de passe : root

Si necessaire, adaptez ces valeurs a votre environnement.

## Configuration de la base de donnees

Deux scripts SQL sont fournis dans SQL :

- sqlDeBase.txt : script de creation des tables + donnees de test
- sqlExport.sql : export SQL existant

Etapes conseillees :

1. Creer la base si elle n existe pas (nom attendue : sys).
2. Executer SQL/sqlDeBase.txt.
3. Verifier que les tables suivantes existent :
   - Utilisateur
   - Categorie
   - Salle
   - Equipement
   - Contenance
   - Reservation

## Lancer le projet en local

Depuis la racine du projet, lancer :

```bash
php -S localhost:8000 index.php
```

Puis ouvrir :

http://localhost:8000

## Routes principales

### Public

- /
- /Salle
- /Salle/Details/{numero}
- /connexion
- /inscription

### Utilisateur connecte

- /Reservation
- /create-reservation
- /delete-reservation?id={id}
- /Equipement
- /Profil
- /Utilisateur
- /deconnexion

### Administration (role admin)

- /admin
- /admin/users
- /admin/categories
- /admin/salles
- /admin/equipements
- /admin/contenances
- /admin/reservations

## Structure du projet

- index.php : point d entree, chargement des controleurs
- Config : connexion base de donnees
- Controllers : logique de routage et traitement des actions
- Models : acces et operations base de donnees
- Views : pages, templates, composants UI
- Assets : CSS, images
- SQL : scripts de creation/mise a jour de la base

## Notes

- L application utilise la session PHP pour l authentification.
- Les mots de passe sont verifies avec password_verify et stockes hashes.
- Les routes distinguent les majuscules/minuscules telles qu implementees dans les controleurs.
- Pour la production, securiser la configuration BDD et adapter le serveur web (Apache/Nginx).
