Voici une version **propre, structurée et détaillée en Markdown**, prête à copier-coller 👇

---

# 🧱 Guide de mise en place d’un projet MVC avec base de données

## 1. Création de la base de données (BDD)

### 🔹 BDD vide
- Se baser sur un **exemple (ex: Nathan)** pour la structure.
- Respecter une **cohérence de nommage** :
  - Choisir **avec ou sans “s”** pour les entités (ex: `user` ou `users`, mais pas les deux).
  - Utiliser des **préfixes explicites** :
    - `uti_nom`, `uti_email`, etc.
  - Bien nommer les **clés étrangères** :
    - ✅ `bat_lieu_id`
    - ❌ `lieu_id`

- Générer la base :
  - Créer un **MCD (Modèle Conceptuel de Données)**.
  - L’envoyer à une IA pour générer le SQL.

---

### 🔹 BDD avec des données
- Remplir la base avec environ **20 lignes de données** via IA.
- Fournir :
  - Le **schéma SQL**
- Demander à l’IA :
  - Des données variées :
    - noms différents
    - emails différents
    - mots de passe différents

---

### 🔹 Test de connexion à la BDD
- Tester avec :
  - **MySQL Workbench** ou autre outil
- Connexion possible :
  - en **localhost**
  - ou sur un **serveur distant (ex: école)**

---

## 2. Structure du projet MVC

Créer les dossiers principaux :

```

Assets/
Config/
Controllers/
Models/
SQL/
Views/

```

Dans `Views/` :
```

Views/
├── Components/
├── equipement/
├── reservation/
├── salle/
├── users/
├── base.php
└── index.php

````

---

## 3. Connexion à la base de données

📁 `Config/connectDatabase.php`

```php
<?php
try {
    $pdo = new PDO(
        "mysql:host=10.10.67.227;dbname=Farhan;port=3306",
        "Farhan",
        "root",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ]
    );
} catch (PDOException $e) {
    $message = $e->getMessage();
    die($message);
}
````

---

## 4. Fichier d’entrée (index.php)

📁 `index.php`

```php
<?php
session_start();

require_once("Config/connectDatabase.php");
require_once("Controllers/<tonProjet>Controller.php");
```

---

## 5. Mise en place du système MVC

⚠️ À faire **en parallèle (3 choses)** :

---

### 🔹 5.1 Layout principal

📁 `Views/base.php`

```php
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Assets/CSS/style.css">
    <title><?= $title ?></title>
</head>

<body>
    <header class="glass">
        <!-- Header vide pour l’instant -->
    </header>

    <main class="fade-in">
        <?php require_once($template); ?>
    </main>

    <footer class="fade-in">
        <!-- Footer vide pour l’instant -->
    </footer>
</body>
</html>
```

---

### 🔹 5.2 Controller principal

📁 `Controllers/<tonProjet>Controller.php`

```php
<?php

$uri = $_SERVER["REQUEST_URI"];

if ($uri == "/index.php" || $uri == "/") {
    $template = "Views/<tonProjet>/pageAccueil.php";
    $title = "Accueil";
}
```

---

### 🔹 5.3 Vue (page d’accueil)

📁 `Views/<tonProjet>/pageAccueil.php`

```php
<h1>Bienvenue sur mon projet</h1>
<h2>Accueil</h2>

<!-- Ajouter ici le contenu HTML -->
```

---

## 6. Lancement du projet

* Lancer avec :

  * **PHP Server (extension VS Code)** ou serveur local
* Ouvrir :

  * `index.php`

✅ Résultat attendu :

```
Bienvenue sur mon projet
Accueil
```

---

## ✅ Résumé rapide

1. Créer BDD (vide → avec données)
2. Tester connexion
3. Créer structure MVC
4. Configurer PDO
5. Créer :

   * base.php
   * Controller
   * Vue
6. Lancer le projet

---

## 💡 Bonnes pratiques

* Toujours garder un **naming cohérent**
* Séparer clairement :

  * logique (Controller)
  * affichage (View)
  * données (Model / BDD)
* Tester chaque étape avant de continuer

---