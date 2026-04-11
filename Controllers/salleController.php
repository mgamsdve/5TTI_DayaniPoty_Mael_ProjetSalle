<?php
// Récupère le chemin demandé pour choisir la page de salle à afficher.
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
// Découpe l'URL en morceaux pour extraire un numéro de salle si nécessaire.
$segments = explode("/", trim($uri, "/"));

// Charge les modèles nécessaires pour enrichir l'affichage des salles.
require_once("Models/salleModel.php");
require_once("Models/contenanceModel.php");
require_once("Models/reservationModel.php");
require_once("Models/categorieModel.php");

if ($uri == "/index.php" || $uri == "/") {
    // L'accueil réutilise les salles pour mettre en avant des espaces disponibles.
    $salles = selectAllSalle($pdo);
    $template = "Views/salle/pageAccueil.php";
    $title = "Accueil";
} elseif ($uri == "/Salle") {
    // La page salle liste toutes les salles disponibles.
    $salles = selectAllSalle($pdo);
    $template = "Views/salle/pageSalle.php";
    $title = "Salle";
} elseif ($segments[0] == "Salle" && $segments[1] == "Details") {
    // Le détail de salle lit le numéro directement depuis l'URL.
    $numeroSalle = $segments[2];
    // Cherche la salle correspondante pour afficher sa fiche.
    $salle = selectSalleByNumero($pdo, $numeroSalle);

    if ($salle) {
        // Si la salle existe, on charge les données liées pour enrichir la fiche.
        $equipementsSalle = selectContenancesBySalleId($pdo, $salle->id_salle);
        $reservationsSalle = selectReservationsBySalleId($pdo, $salle->id_salle);
        $categorieSalle = selectCategoryById($pdo, $salle->id_categorie);
    } else {
        // Sinon on prépare des valeurs vides pour éviter les erreurs de vue.
        $equipementsSalle = [];
        $reservationsSalle = [];
        $categorieSalle = null;
    }

    $template = "Views/salle/pageSalleDetails.php";
    $title = "Details Salle";
}

if (isset($template)) {
    // Rend la vue dans le layout commun du site.
    require_once("Views/base.php");
}
