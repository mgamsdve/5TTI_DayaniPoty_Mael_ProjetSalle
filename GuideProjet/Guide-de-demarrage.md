# Guide de démarrage — Projet MVC PHP

## 0. Prérequis

Installe un environnement local :
- **Laragon** (recommandé Windows) — Apache + PHP + MySQL en un clic
- **XAMPP** (Windows/Mac) — même chose
- **MAMP** (Mac)

Lance le serveur. Vérifie que `http://localhost` répond dans le navigateur.

Installe l'extension **PHP Server** dans VS Code, ou utilise le serveur intégré de PhpStorm/Laragon.

---

## 1. Créer la base de données

### 1.1 Ouvrir phpMyAdmin

Accède à `http://localhost/phpmyadmin` (Laragon/XAMPP).

**Nouvelle base de données** → entre un nom (ex : `mon_projet`) → **Créer**.

Ou via MySQL Workbench :

```sql
CREATE DATABASE mon_projet CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 1.2 Créer les tables

Colle le contenu de ton fichier SQL (voir dossier `SQL/`) dans l'onglet **SQL** de phpMyAdmin et exécute.

Structure minimale obligatoire — table `Utilisateur` :

```sql
CREATE TABLE Utilisateur (
    id_utilisateur INT AUTO_INCREMENT NOT NULL,
    uti_nom        VARCHAR(50)  NOT NULL,
    uti_prenom     VARCHAR(50)  NOT NULL,
    uti_email      VARCHAR(100) NOT NULL UNIQUE,
    uti_mdp        VARCHAR(255) NOT NULL,
    uti_role       ENUM('utilisateur','admin') DEFAULT 'utilisateur',
    PRIMARY KEY (id_utilisateur)
) ENGINE=InnoDB;
```

Ajoute ensuite les tables propres à ton projet (voitures, bateaux, livres, etc.).  
Voir [guide-bdd.md](guide-bdd.md) pour les conventions de nommage et les exemples SQL complets.

### 1.3 Vérification

Dans phpMyAdmin → onglet **Structure** : tu dois voir tes tables.  
Insère une ligne de test manuellement, vérifie qu'elle apparaît dans **Parcourir**.

---

## 2. Structure des dossiers

Crée ces dossiers à la racine de ton projet (dans `htdocs/` pour XAMPP, `www/` pour Laragon) :

```text
MonProjet/
├── index.php
├── Config/
│   └── connectDatabase.php
├── Controllers/
│   └── monProjetController.php
├── Models/
│   └── monProjetModel.php
├── Views/
│   ├── base.php
│   ├── Components/
│   │   ├── header.php
│   │   └── footer.php
│   └── monProjet/
│       └── pageAccueil.php
├── Assets/
│   └── CSS/
│       └── style.css
└── SQL/
    └── script.sql
```

---

## 3. Connexion à la base de données

### Fichier : `Config/connectDatabase.php`

```php
<?php
try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=mon_projet;port=3306",
        // adapte dbname avec le nom exact de ta base
        // si tu utilises le serveur de l'école, remplace localhost par l'IP (ex: 10.10.67.227)
        "root",
        "root",
        // mot de passe : souvent "" sur XAMPP, "root" sur Laragon
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ]
    );
} catch (PDOException $e) {
    die($e->getMessage());
}
```

### 3.1 Vérification de la connexion

Crée temporairement un fichier `test.php` à la racine :

```php
<?php
require_once "Config/connectDatabase.php";
echo "Connexion OK";
```

Ouvre `http://localhost/MonProjet/test.php`.  
Tu dois voir **Connexion OK**.  
Si tu vois un message d'erreur PDO, corrige `host`, `dbname` ou le mot de passe.  
**Supprime `test.php` une fois la connexion confirmée.**

---

## 4. Point d'entrée

### Fichier : `index.php`

```php
<?php
session_start();
// session_start() DOIT être la première ligne — avant tout output HTML

require_once "Config/connectDatabase.php";
require_once "Controllers/userController.php";
require_once "Controllers/monProjetController.php";
// ajoute un require_once par controller
// userController doit être avant les controllers qui protègent leurs routes
```

`index.php` ne gère pas les routes lui-même. Il se contente d'inclure les controllers.  
C'est chaque controller qui lit l'URL et décide quoi afficher.

---

## 5. Layout principal

### Fichier : `Views/base.php`

```php
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Assets/CSS/style.css">
    <title><?= $title ?></title>
</head>
<body>
    <header>
        <?php require_once("Views/Components/header.php"); ?>
    </header>

    <main>
        <?php require_once($template); ?>
        <!-- $template est une variable définie par le controller avant d'inclure base.php -->
    </main>

    <footer>
        <?php require_once("Views/Components/footer.php"); ?>
    </footer>
</body>
</html>
```

`base.php` est la coquille commune à toutes les pages.  
Le controller définit `$template` (chemin vers la vue) et `$title` (titre de la page), puis inclut `base.php`.

---

## 6. Premier controller

### Fichier : `Controllers/monProjetController.php`

```php
<?php
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
// parse_url() extrait uniquement le chemin, sans les paramètres GET (?foo=bar)
// $_SERVER["REQUEST_URI"] tout seul peut casser avec des query strings

require_once("Models/monProjetModel.php");

if ($uri == "/" || $uri == "/index.php") {
    $title    = "Accueil";
    $template = "Views/monProjet/pageAccueil.php";
}

// TOUJOURS à la fin du controller :
if (isset($template)) {
    require_once("Views/base.php");
}
```

**Important** : `require_once("Views/base.php")` se fait depuis le controller, **pas** depuis `index.php`.  
C'est `base.php` qui inclut la vue via `require_once($template)`.

---

## 7. Premières vues

### Fichier : `Views/monProjet/pageAccueil.php`

```php
<h1>Accueil</h1>
<p>Bienvenue sur mon projet.</p>
```

### Fichier : `Views/Components/header.php`

```php
<nav>
    <a href="/">Accueil</a>
</nav>
```

### Fichier : `Views/Components/footer.php`

```php
<p>&copy; Mon Projet</p>
```

---

## 8. Vérification 1 — la page s'affiche

Lance le projet (PHP Server ou XAMPP/Laragon).  
Ouvre l'URL racine du projet.

Tu dois voir :
```
Accueil
Bienvenue sur mon projet.
```

Si tu vois une page blanche ou une erreur PHP :
- Vérifie les chemins dans les `require_once`
- Vérifie que `$template` est bien défini avant `require_once("Views/base.php")`
- Ajoute temporairement `var_dump($template);` avant le `require_once` pour déboguer

---

## 9. Premier model — requête SELECT

### Fichier : `Models/monProjetModel.php`

```php
<?php

// Adapte le nom de la fonction et le nom de la table à ton projet
// Exemples : selectAllVoitures(), selectAllBateaux(), selectAllLivres()...

function selectAllElements($pdo)
{
    try {
        $query = 'SELECT * FROM NomDeTaTable';
        // adapte NomDeTaTable au vrai nom de ta table SQL
        $stmt  = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
        // fetchAll() retourne un tableau d'objets
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
```

### Mettre à jour le controller

```php
<?php
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

require_once("Models/monProjetModel.php");

if ($uri == "/" || $uri == "/index.php") {
    $elements = selectAllElements($pdo);
    // $elements sera disponible dans la vue
    $title    = "Accueil";
    $template = "Views/monProjet/pageAccueil.php";
}

if (isset($template)) {
    require_once("Views/base.php");
}
```

### Afficher dans la vue

```php
<h1>Accueil</h1>

<ul>
    <?php foreach ($elements as $element) : ?>
        <li><?= htmlspecialchars($element->nom_du_champ) ?></li>
        <!-- adapte nom_du_champ au vrai nom de colonne dans ta table -->
    <?php endforeach ?>
</ul>
```

---

## 10. Vérification 2 — les données s'affichent

Tu dois voir la liste des éléments de ta table.

- Liste vide → insère des données de test dans phpMyAdmin
- Erreur PDO → vérifie le nom exact de la table et des colonnes (casse comprise)
- Page blanche → erreur PHP silencieuse, active les erreurs temporairement :

```php
// à mettre en haut de index.php pendant le développement
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

---

## 11. Ajouter une deuxième route

Dans le controller, `elseif` pour chaque nouvelle URL :

```php
if ($uri == "/" || $uri == "/index.php") {
    $elements = selectAllElements($pdo);
    $title    = "Accueil";
    $template = "Views/monProjet/pageAccueil.php";

} elseif ($uri == "/liste") {
    // adapte /liste à l'URL de ta page
    $elements = selectAllElements($pdo);
    $title    = "Liste complète";
    $template = "Views/monProjet/pageListe.php";
}

if (isset($template)) {
    require_once("Views/base.php");
}
```

---

## 12. Route avec paramètre dans l'URL

Exemple : `/Article/Details/42` ou `/Bateau/Details/B01`

```php
$uri      = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$segments = explode("/", trim($uri, "/"));
// /Article/Details/42 → $segments = ["Article", "Details", "42"]

if ($segments[0] == "Article" && isset($segments[1]) && $segments[1] == "Details") {
    $id       = $segments[2];
    // adapte Article et Details aux noms de ton projet
    $element  = selectElementById($pdo, $id);
    $title    = "Détail";
    $template = "Views/monProjet/pageDetail.php";
}
```

Model correspondant :

```php
function selectElementById($pdo, $id)
{
    try {
        $query = 'SELECT * FROM NomDeTaTable WHERE id_nomtable = :id';
        $stmt  = $pdo->prepare($query);
        $stmt->execute(["id" => $id]);
        return $stmt->fetch();
        // fetch() retourne un seul objet (pas un tableau)
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
```

Vue correspondante :

```php
<?php if ($element) : ?>
    <h1><?= htmlspecialchars($element->nom_du_champ) ?></h1>
    <p><?= htmlspecialchars($element->autre_champ) ?></p>
<?php else : ?>
    <p>Élément introuvable.</p>
<?php endif ?>
```

---

## 13. Ajouter des routes POST (formulaires)

Un formulaire POST sur `/inscription` :

```php
if ($uri == "/inscription") {
    if (isset($_POST["envoyer"])) {
        // traitement du formulaire
        insertElement($pdo);
        header("location:/");
        exit;
        // TOUJOURS exit après header("location:...")
    }

    $title    = "Inscription";
    $template = "Views/users/pageInscription.php";
}
```

Vue avec formulaire :

```php
<form method="POST">
    <input type="text"   name="nom"    placeholder="Nom">
    <input type="email"  name="email"  placeholder="Email">
    <input type="submit" name="envoyer" value="Envoyer">
</form>
```

---

## 14. Résumé du flux MVC

```text
Requête HTTP
    ↓
index.php           session_start() + require_once controllers
    ↓
Controller          lit $uri avec parse_url()
                    vérifie les droits (session, rôle)
                    appelle les fonctions Model si besoin
                    définit $template et $title
    ↓
Model               exécute les requêtes SQL
                    retourne les données ($pdo->prepare + execute + fetch/fetchAll)
    ↓
Controller          passe les données aux vues via variables PHP ($elements, $item...)
                    inclut Views/base.php si $template est défini
    ↓
Views/base.php      structure HTML globale
                    inclut header.php, le $template, footer.php
    ↓
Vue ($template)     affiche les données avec foreach / if / htmlspecialchars
```

Règles :
- Requêtes SQL → uniquement dans les **Models**
- Logique (conditions, redirections) → uniquement dans les **Controllers**
- Affichage HTML → uniquement dans les **Views**
- `require_once("Views/base.php")` → toujours à la **fin** du controller

---

## 15. Guides complémentaires

- [guide-session.md](guide-session.md) — inscription, connexion, session, profil
- [guide-crud.md](guide-crud.md) — CRUD complet (admin : ajout, modification, suppression)
- [guide-bdd.md](guide-bdd.md) — conception BDD, JOIN, tables de liaison
- [vue-global.md](vue-global.md) — vue d'ensemble de l'architecture du projet
