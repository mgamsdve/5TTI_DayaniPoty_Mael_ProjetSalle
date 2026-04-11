<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Déclare l'encodage et prépare l'affichage responsive de la page. -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Charge la police utilisée pour homogénéiser l'interface. -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700;0,14..32,800&display=swap" rel="stylesheet">
    <!-- Charge la feuille de style principale du projet. -->
    <link rel="stylesheet" href="/Assets/CSS/style.css">
    <!-- Charge le script de filtre réutilisé sur plusieurs listes. -->
    <script src="/Assets/JS/search-filter.js"></script>
    <title><?= $title ?></title>
</head>

<body>
    <header>
        <!-- Injecte le menu commun du site. -->
        <?php require_once("Views/Components/header.php"); ?>
    </header>

    <main class="fade-in">
        <!-- Affiche ici la vue choisie par le contrôleur courant. -->
        <?php require_once($template); ?>
    </main>

    <footer>
        <!-- Injecte le pied de page commun. -->
        <?php require_once("Views/Components/footer.php"); ?>
    </footer>

    <!-- Charge les icônes Lucide utilisées dans l'interface. -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <!-- Initialise les icônes après leur chargement. -->
    <script>lucide.createIcons();</script>
</body>

</html>
