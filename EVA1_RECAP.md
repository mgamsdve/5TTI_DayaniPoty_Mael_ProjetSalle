# EVA1_RECAP

Le projet parle surtout de **réservations** plutôt que de "commandes". J'emploie donc le vocabulaire du projet quand la fonctionnalité demandée correspond à une réservation.

## Architecture MVC

### Répertoire `Config`, `Controllers`, `Models`, `Views`
Présence : **oui**  
Fichiers concernés : `index.php`, `Config/connectDatabase.php`, `Config/connectDatabase2.php`, `Controllers/*.php`, `Models/*.php`, `Views/base.php`

```php
<?php
session_start();
require_once "Config/connectDatabase.php";
require_once "Controllers/userController.php";
require_once "Controllers/salleController.php";
require_once "Controllers/reservationController.php";
require_once "Controllers/equipementController.php";
require_once "Controllers/adminController.php";
```

Le point d'entrée charge la session, la connexion PDO et tous les contrôleurs. Chaque contrôleur choisit ensuite un `$template` puis la vue de base affiche la page correspondante.

## Pages Invite

### Accueil : contenu au choix
Présence : **oui**  
Fichiers concernés : `Controllers/salleController.php`, `Views/salle/pageAccueil.php`, `Models/salleModel.php`

```php
<?php
$featuredSalles = array_slice($salles ?? [], 0, 3);
$sallesCount = count($salles ?? []);
?>

<div class="home-page">
    <section class="hero-section animate-on-scroll">
        <div class="hero-inner">
            <h1 class="hero-title">Reservez vos espaces de travail en toute simplicite</h1>
            <p class="hero-subtitle">Centralisez les salles, planifiez vos reunions et gagnez du temps avec une experience fluide et elegante.</p>
```

La page d'accueil est une landing page de présentation avec hero, statistiques et salles mises en avant. Le contrôleur charge les salles, puis la vue compose le contenu public autour de ces données.

### Inscription
Présence : **oui**  
Fichiers concernés : `Controllers/userController.php`, `Models/userModel.php`, `Views/users/pageInscription.php`

```php
<?php
if ($uri == "/inscription") {
    if (isset($_POST["envoyer"])) {
        $messageError = verifEmptyData();

        if (!$messageError) {
            $userExist = selectUserByEmail($pdo, $_POST["email"]);

            if ($userExist === false) {
                insertUser($pdo);
                header("location:/connexion");
                exit;
            } else {
                $messageError["email"] = "Cette adresse email est déjà utilisée.";
            }
        }
    }
```

L'inscription vérifie d'abord que les champs ne sont pas vides, puis contrôle l'unicité de l'email. Si tout est valide, le modèle insère l'utilisateur avec le rôle `utilisateur` et redirige vers la connexion.

### Connexion
Présence : **oui**  
Fichiers concernés : `Controllers/userController.php`, `Models/userModel.php`, `Views/users/pageConnexion.php`

```php
<?php
} elseif ($uri == "/connexion") {
    $message = null;
    if (isset($_POST["envoyer"])) {
        $user = selectUserByEmailAndPassword($pdo);
        if ($user) {
            $_SESSION["user"] = $user;
            header("location:/");
            $message = "Connecté";
        } else {
            $message = "Mauvais email ou MDP";
        }
    }
    $template = "Views/users/pageConnexion.php";
    $title = "Connexion";
}
```

La connexion repose sur une recherche par email puis une vérification du mot de passe hashé. En cas de succès, l'utilisateur est stocké dans `$_SESSION["user"]` pour piloter l'accès aux pages protégées.

## Pages Utilisateur

### Accueil utilisateur : table de liaison filtrée sur l'id utilisateur + affichage des données de la FK
Présence : **oui**  
Fichiers concernés : `Controllers/reservationController.php`, `Models/reservationModel.php`, `Views/reservation/pageReservation.php`

```php
function selectReservationsByUserId($pdo, $idUtilisateur)
{
    try {
        $query = 'SELECT Reservation.*, Salle.sal_nom, Salle.sal_image, Salle.sal_numero
            FROM Reservation
            INNER JOIN Salle ON Salle.id_salle = Reservation.id_salle
            WHERE Reservation.id_utilisateur = :idUtilisateur
            ORDER BY Reservation.res_dateDebut DESC';
        $selectReservations = $pdo->prepare($query); //preparer la query
        $selectReservations->execute([
            "idUtilisateur" => $idUtilisateur
        ]); //executer la query
        $reservations = $selectReservations->fetchAll(); //recuperer les donnees
        return $reservations;
    }
```

La requête filtre les réservations sur l'id de l'utilisateur connecté et joint la table `Salle`. La vue affiche ensuite les champs issus de la clé étrangère, comme le nom, le numéro et l'image de la salle.

### Afficher les détails d'une commande (utilisation de GET)
Présence : **non**  
Fichiers concernés : aucun fichier dédié trouvé pour une fiche de réservation/commande

```php
if (
    count($segments) >= 4 &&
    $segments[0] == "admin" &&
    $segments[1] == "users" &&
    $segments[2] == "details"
) {
    $idUser = (int) $segments[3];
    $userDetails = selectUserById($pdo, $idUser);
    $userReservations = [];
```

Le projet contient bien un détail en GET, mais il concerne une fiche utilisateur dans l'administration, pas une commande/réservation. Je n'ai pas trouvé de route dédiée du type "détail de commande" avec GET dans le code source.

### Insérer plusieurs lignes en une fois dans la table de liaison (MULTI SELECT)
Présence : **oui**  
Fichiers concernés : `Controllers/reservationController.php`, `Models/reservationModel.php`, `Views/reservation/pageCreerReservation.php`

```php
function insertReservationsMultiForUser($pdo)
{
    try {
        $idSalles = $_POST["id_salles"] ?? [];
        $idUtilisateur = (int) $_SESSION["user"]->id_utilisateur;
        $dateDebut = $_POST["dateDebut"] ?? "";
        $dateFin = $_POST["dateFin"] ?? "";

        if (empty($idSalles)) {
            return;
        }

        $query = 'INSERT INTO Reservation (id_salle, id_utilisateur, res_dateDebut, res_dateFin)
            VALUES (:idSalle, :idUtilisateur, :dateDebut, :dateFin)';
```

Le formulaire accepte plusieurs salles via `id_salles[]`, puis le modèle parcourt la liste pour insérer une réservation par salle. Le contrôleur ajoute aussi des contrôles de dates avant l'insertion.

### Mettre à jour son compte (variable SESSION)
Présence : **oui**  
Fichiers concernés : `Controllers/userController.php`, `Models/userModel.php`, `Views/users/pageProfil.php`

```php
} elseif ($uri == "/Profil") {
    if (isset($_POST["envoyer"])) {

        if (
            empty($_POST["nom"]) ||
            empty($_POST["prenom"]) ||
            empty($_POST["email"])
        ) {
            $erreur = "Tous les champs doivent être remplis";
        } else {
            updateUser($pdo);
            updateSession($pdo);
            header("location:/Profil");
        }
    }
```

La mise à jour du profil utilise l'utilisateur stocké en session pour identifier la ligne à modifier. Après l'UPDATE, la session est relue afin que les informations affichées restent synchronisées avec la base.

### Supprimer son compte avec la variable de session USER (connecté)
Présence : **oui**  
Fichiers concernés : `Controllers/userController.php`, `Models/userModel.php`, `Views/users/pageProfil.php`

```php
} elseif ($uri == "/deleteProfil") {
    deleteUser($pdo);
    session_destroy();
    header("location:/");
    $template = "Views/users/pageProfil.php";
    $title = "Mon Profil";
}

function deleteUser($pdo)
{
    try {
        $query = 'DELETE FROM utilisateur WHERE id_utilisateur = :userId';
        $insertUser = $pdo->prepare($query);
        $insertUser->execute([
            "userId"   => $_SESSION["user"]->id_utilisateur
        ]);
```

La suppression du compte cible directement l'id présent dans `$_SESSION["user"]`. Après la suppression, la session est détruite et l'utilisateur est renvoyé vers l'accueil.

## Pages Admin

### Accueil : liste de la table de liaison avec affichage des données des FK
Présence : **oui**  
Fichiers concernés : `Controllers/adminController.php`, `Models/reservationModel.php`, `Views/admin/pageAdminReservations.php`

```php
function selectAllReservations($pdo)
{
    try {
        $query = 'SELECT Reservation.*, Salle.sal_nom, Salle.sal_numero, Utilisateur.uti_nom, Utilisateur.uti_prenom
            FROM Reservation
            INNER JOIN Salle ON Salle.id_salle = Reservation.id_salle
            INNER JOIN Utilisateur ON Utilisateur.id_utilisateur = Reservation.id_utilisateur
            ORDER BY Reservation.res_dateDebut DESC';
        $selectReservations = $pdo->prepare($query);
        $selectReservations->execute();
        $reservations = $selectReservations->fetchAll();
        return $reservations;
    }
```

L'administration affiche toutes les réservations avec les informations des deux clés étrangères, salle et utilisateur. Le tri par date de début rend la liste plus lisible pour la gestion courante.

### Lien sur le nom pour avoir une fiche client (utilisation de GET)
Présence : **oui**  
Fichiers concernés : `Controllers/adminController.php`, `Views/admin/pageAdminUsers.php`, `Views/admin/pageAdminUserDetails.php`

```php
<td>
    <a href="/admin/users/details/<?= $user->id_utilisateur ?>" class="admin-user-link">
        <?= htmlspecialchars($user->uti_nom) ?>
    </a>
</td>
<td><input type="text" name="prenom" value="<?= $user->uti_prenom ?>" form="user-form-<?= $user->id_utilisateur ?>" required></td>
<td><input type="email" name="email" value="<?= $user->uti_email ?>" form="user-form-<?= $user->id_utilisateur ?>" required></td>
<td>
    <select name="role" form="user-form-<?= $user->id_utilisateur ?>">
```

Le nom du client est un lien GET vers une fiche détaillée. Cette fiche est gérée par une route dédiée qui charge l'utilisateur et ses réservations associées.

### Modifier la table de liaison avec 2 selects (les 2 clés secondaires)
Présence : **oui**  
Fichiers concernés : `Controllers/adminController.php`, `Views/admin/pageAdminReservations.php`

```php
<td>
    <select name="id_salle" form="reservation-form-<?= $reservation->id_reservation ?>">
        <?php foreach ($salles as $salle) : ?>
            <option value="<?= $salle->id_salle ?>" <?= $reservation->id_salle == $salle->id_salle ? "selected" : "" ?>><?= $salle->sal_nom ?> (<?= $salle->sal_numero ?>)</option>
        <?php endforeach ?>
    </select>
</td>
<td>
    <select name="id_utilisateur" form="reservation-form-<?= $reservation->id_reservation ?>">
```

Chaque ligne de réservation peut être réassignée à une autre salle et à un autre utilisateur via deux listes déroulantes. Le formulaire associé envoie ensuite l'action `updateReservation` vers le contrôleur admin.

### Supprimer une ligne de la table de liaison
Présence : **oui**  
Fichiers concernés : `Controllers/adminController.php`, `Views/admin/pageAdminReservations.php`, `Models/reservationModel.php`

```php
<td>
    <form method="POST" class="admin-inline-form">
        <input type="hidden" name="action" value="deleteReservation">
        <input type="hidden" name="id_reservation" value="<?= $reservation->id_reservation ?>">
        <button type="submit" class="btn-danger">Supprimer</button>
    </form>
</td>
```

La suppression d'une réservation se fait ligne par ligne depuis le tableau d'administration. Le contrôleur récupère l'id posté et appelle le modèle `deleteReservation()`.

### Supprimer 1 compte avec GET
Présence : **oui**  
Fichiers concernés : `Controllers/adminController.php`, `Models/userModel.php`, `Views/admin/pageAdminUsers.php`

```php
if ($_GET["action"] == "deleteUserGet" && !empty($_GET["id_utilisateur"])) {
    $idUser = (int) $_GET["id_utilisateur"];

    // Evite de supprimer le compte admin connecte depuis l'admin.
    if ($idUser > 0 && $idUser != (int) $_SESSION["user"]->id_utilisateur) {
        deleteUserById($pdo);
    }

    header("location:/admin/users");
    exit;
}
```

La suppression passe par GET pour respecter le critère demandé, avec une protection supplémentaire pour éviter de supprimer l'administrateur connecté. Le modèle supprime ensuite la ligne ciblée par `id_utilisateur`.

### Supprimer plusieurs utilisateurs (MULTI SELECT)
Présence : **oui**  
Fichiers concernés : `Controllers/adminController.php`, `Models/userModel.php`, `Views/admin/pageAdminUsers.php`

```php
<td>
    <input
        type="checkbox"
        name="user_ids[]"
        value="<?= $user->id_utilisateur ?>"
        form="bulk-delete-users-form"
        aria-label="Selectionner l'utilisateur <?= $user->id_utilisateur ?>"
    >
</td>
...
<form method="POST" id="bulk-delete-users-form" hidden>
    <input type="hidden" name="action" value="deleteUsersMulti">
</form>
```

Le tableau permet de cocher plusieurs utilisateurs puis de lancer une suppression groupée. Le contrôleur boucle sur les identifiants reçus et exécute une suppression par utilisateur.

### Supprimer plusieurs lignes d'une autre table que utilisateur avec une FK (MULTI SELECT)
Présence : **oui**  
Fichiers concernés : `Controllers/adminController.php`, `Models/salleModel.php`, `Views/admin/pageAdminSalles.php`

```php
<td>
    <input
        type="checkbox"
        name="salle_ids[]"
        value="<?= $salle->id_salle ?>"
        form="bulk-delete-salles-form"
        aria-label="Selectionner la salle <?= $salle->id_salle ?>"
    >
</td>
...
<form method="POST" id="bulk-delete-salles-form" hidden>
    <input type="hidden" name="action" value="deleteSallesMulti">
</form>
```

La suppression multiple est aussi disponible pour les salles, qui sont liées à une catégorie par clé étrangère. Le modèle `deleteSallesByIds()` traite chaque id reçu dans `$_POST["salle_ids"]`.

## Menu Invite

### Liens Connexion, Inscription
Présence : **oui**  
Fichiers concernés : `Views/Components/header.php`

```php
<div class="navbar-actions">
    <?php if (isset($_SESSION["user"])) : ?>
        <div class="navbar-user">
            <div class="navbar-avatar">
                <?= strtoupper(substr($_SESSION["user"]->uti_prenom, 0, 1) . substr($_SESSION["user"]->uti_nom, 0, 1)) ?>
            </div>
            <span><?= htmlspecialchars($_SESSION["user"]->uti_prenom) ?></span>
        </div>
        <a href="/Profil" class="btn-outline-sm">Profil</a>
        <a href="/deconnexion" class="btn-sm">Déconnexion</a>
    <?php else : ?>
        <a href="/connexion" class="btn-outline-sm">Connexion</a>
        <a href="/inscription" class="btn-sm">Inscription</a>
    <?php endif ?>
</div>
```

Le menu public affiche les liens d'authentification tant qu'aucune session utilisateur n'existe. Dès que l'utilisateur se connecte, ces liens sont remplacés par les actions du compte.

## Menu Utilisateur

### Mes commandes
Présence : **partiel**  
Fichiers concernés : `Views/Components/header.php`, `Views/reservation/pageReservation.php`

```php
<?php if (isset($_SESSION["user"])) : ?>
    <a href="/Reservation">Mes réservations</a>
    <a href="/Utilisateur">Utilisateurs</a>
    <?php if ($_SESSION["user"]->uti_role == "admin") : ?>
        <div class="navbar-dropdown">
            <button class="navbar-dropdown-btn">
                Admin <i data-lucide="chevron-down"></i>
            </button>
```

Le projet propose bien l'accès aux réservations de l'utilisateur, mais l'intitulé exact est "Mes réservations" et non "Mes commandes". La fonctionnalité est présente sur le fond, avec un vocabulaire différent.

### Nouvelle(s) commande(s)
Présence : **partiel**  
Fichiers concernés : `Views/reservation/pageReservation.php`, `Views/salle/pageSalle.php`, `Views/salle/pageSalleDetails.php`

```php
<div class="page-header">
    <h1>Mes Réservations</h1>
    <a href="/create-reservation" class="btn">
        <i data-lucide="plus"></i>
        Nouvelle réservation
    </a>
</div>
```

Il n'y a pas de lien de menu utilisateur dédié dans le header, mais l'action de création est bien disponible sur les pages de réservations et de salles. Le parcours mène vers `/create-reservation`, qui ouvre le formulaire de multi-sélection.

### Mise à jour du profil, suppression du profil, Déconnexion
Présence : **oui**  
Fichiers concernés : `Views/users/pageProfil.php`, `Views/Components/header.php`, `Controllers/userController.php`

```php
    <div id="profile-links" class="profile-actions">
        <a href="" class="btn-link">Réinitialiser le mot de passe</a>
        <a href="/deconnexion" class="btn-link">Se déconnecter</a>
        <a href="deleteProfil" class="btn-danger">Supprimer le compte</a>
    </div>
</div>
```

Le profil regroupe les actions essentielles du compte utilisateur. La suppression et la déconnexion sont accessibles depuis cette page, tandis que la mise à jour passe par le formulaire principal du profil.

## Menu Admin

### Modifier les réservations, supprimer une réservation, déconnexion
Présence : **partiel**  
Fichiers concernés : `Views/Components/admin-sidebar.php`, `Views/admin/pageAdminReservations.php`, `Views/Components/header.php`

```php
<aside class="admin-sidebar">
    <div class="admin-sidebar-brand">
        <i data-lucide="building-2"></i>
        <span>RoomBook</span>
    </div>

    <a href="/admin" class="sidebar-link">
        <i data-lucide="layout-dashboard"></i>
        <span>Dashboard</span>
    </a>
    <a href="/admin/users" class="sidebar-link">
```

Le menu admin dédié donne accès aux modules d'administration, dont les réservations. En revanche, la déconnexion n'apparaît pas dans cette sidebar spécifique : elle reste portée par le header global.

### Supprimer 1 utilisateur (GET)
Présence : **oui**  
Fichiers concernés : `Controllers/adminController.php`, `Views/admin/pageAdminUsers.php`

```php
<form method="GET" action="/admin/users" class="admin-inline-form" onsubmit="return confirm('Supprimer cet utilisateur ?');">
    <input type="hidden" name="action" value="deleteUserGet">
    <input type="hidden" name="id_utilisateur" value="<?= $user->id_utilisateur ?>">
    <button type="submit" class="btn-delete btn-delete--compact">Supprimer</button>
</form>
```

Cette action admin utilise GET pour cibler précisément l'utilisateur à supprimer. Le contrôleur filtre l'action, vérifie l'id, puis appelle le modèle de suppression.

### Supprimer plusieurs utilisateurs (MULTI SELECT)
Présence : **oui**  
Fichiers concernés : `Controllers/adminController.php`, `Models/userModel.php`, `Views/admin/pageAdminUsers.php`

```php
<div class="admin-form admin-bulk-card">
    <label for="admin-users-bulk-select" class="mt-0">Suppression multiple (multi select)</label>
    <p>Cochez des utilisateurs dans le tableau puis lancez la suppression de groupe.</p>
    <input type="submit" id="admin-users-bulk-select" value="Supprimer les utilisateurs selectionnes" class="btn-danger" form="bulk-delete-users-form">
</div>
```

Le menu admin propose bien une suppression groupée des utilisateurs, pilotée par des cases à cocher dans le tableau. La logique est la même que dans la page de gestion des salles.

### Supprimer plusieurs lignes d'une autre table que utilisateur (MULTI SELECT)
Présence : **oui**  
Fichiers concernés : `Controllers/adminController.php`, `Models/salleModel.php`, `Views/admin/pageAdminSalles.php`

```php
<div class="admin-form admin-bulk-card">
    <label for="admin-salles-bulk-select" class="mt-0">Suppression multiple (multi select)</label>
    <p>Cochez des salles dans le tableau puis lancez la suppression de groupe.</p>
    <input type="submit" id="admin-salles-bulk-select" value="Supprimer les salles selectionnees" class="btn-danger" form="bulk-delete-salles-form">
</div>
```

Cette fonction couvre une table différente de `utilisateur` et reste reliée à une clé étrangère de catégorie. Le code supprime plusieurs salles en une seule action à partir de leurs identifiants cochés.

## HTML

### Utilisation de l'attribut `required` sur les formulaires
Présence : **oui**  
Fichiers concernés : `Views/users/pageInscription.php`, `Views/reservation/pageCreerReservation.php`, `Views/admin/pageAdminUsers.php`, `Views/admin/pageAdminReservations.php`, `Views/admin/pageAdminSalles.php`

```html
<form action="/create-reservation" method="POST">
    <input type="hidden" name="action" value="createReservation">
    <div class="form-group">
        <label for="id_salles">Salles (selection multiple)</label>
        <select name="id_salles[]" id="id_salles" multiple required size="8">
            <?php foreach ($salles as $salle) : ?>
                <option value="<?= $salle->id_salle ?>">
                    <?= htmlspecialchars($salle->sal_nom) ?> (N°<?= htmlspecialchars($salle->sal_numero) ?>)
                </option>
            <?php endforeach; ?>
        </select>
```

Les formulaires utilisent largement `required` pour bloquer les envois incomplets côté navigateur. La validation serveur complète ensuite la vérification, par exemple sur les champs vides et les dates.

## JavaScript

### Animation 1
Présence : **oui**  
Fichiers concernés : `Assets/JS/home.js`, `Views/salle/pageAccueil.php`

```javascript
const scrollObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add("visible");
        }
    });
}, { threshold: 0.15 });

document.querySelectorAll(".animate-on-scroll").forEach((el) => {
    scrollObserver.observe(el);
});
```

Cette animation révèle progressivement les sections de la page d'accueil lorsqu'elles entrent dans le viewport. Elle repose sur `IntersectionObserver` et l'ajout d'une classe CSS au moment où l'élément devient visible.

### Animation 2
Présence : **oui**  
Fichiers concernés : `Assets/JS/home.js`

```javascript
function animateCounter(el, target, duration = 1500) {
    let start = 0;
    const step = target / (duration / 16);

    const timer = setInterval(() => {
        start += step;

        if (start >= target) {
            el.textContent = String(target);
            clearInterval(timer);
            return;
        }

        el.textContent = String(Math.floor(start));
    }, 16);
}
```

Le compteur anime les statistiques du home en faisant progresser les valeurs à l'écran. C'est une animation purement visuelle, déclenchée quand la section de statistiques devient visible.

### Vérification 1 d'encodage cohérent
Présence : **partiel**  
Fichiers concernés : `Assets/JS/search-filter.js`

```javascript
function normalizeSearchValue(value) {
    return String(value || "")
        .toLowerCase()
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "")
        .trim();
}
```

Ce code ne valide pas un email ou un téléphone, mais il normalise les chaînes pour rendre la recherche cohérente. Il supprime les accents, harmonise la casse et enlève les espaces superflus.

### Vérification 2 d'encodage cohérent
Présence : **partiel**  
Fichiers concernés : `Assets/JS/search-filter.js`

```javascript
function initSelectSearch(config) {
    const input = document.querySelector(config.inputSelector);
    const select = document.querySelector(config.selectSelector);
    const emptyMessage = document.querySelector(config.emptySelector);

    if (!input || !select) {
        return;
    }

    const sourceOptions = Array.from(select.options).map(function (option) {
        return {
            value: option.value,
            text: option.textContent,
            disabled: option.disabled
        };
    });
```

Le projet ne contient pas de validation JavaScript dédiée aux formats email ou téléphone. La logique présente sert surtout à filtrer et reconstruire les options d'un `select` de façon stable et prévisible.
