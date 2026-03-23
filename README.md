# Projet Salle - Application de reservation de salles

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
