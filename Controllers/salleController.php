<?php
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$segments = explode("/", trim($uri, "/"));

require_once("Models/salleModel.php");
require_once("Models/contenanceModel.php");
require_once("Models/reservationModel.php");
require_once("Models/categorieModel.php");

if ($uri == "/index.php" || $uri == "/") {
    $salles = selectAllSalle($pdo);
    $template = "Views/salle/pageAccueil.php";
    $title = "Accueil";
} elseif ($uri == "/Salle") {
    $salles = selectAllSalle($pdo);
    $template = "Views/salle/pageSalle.php";
    $title = "Salle";
} elseif ($segments[0] == "Salle" && $segments[1] == "Details") {
    $numeroSalle = $segments[2];
    $salle = selectSalleByNumero($pdo, $numeroSalle);

    if ($salle) {
        $equipementsSalle = selectContenancesBySalleId($pdo, $salle->id_salle);
        $reservationsSalle = selectReservationsBySalleId($pdo, $salle->id_salle);
        $categorieSalle = selectCategoryById($pdo, $salle->id_categorie);
    } else {
        $equipementsSalle = [];
        $reservationsSalle = [];
        $categorieSalle = null;
    }

    $template = "Views/salle/pageSalleDetails.php";
    $title = "Details Salle";
}

if (isset($template)) {
    require_once("Views/base.php");
}
