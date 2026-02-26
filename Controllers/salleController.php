<?php
$uri = $_SERVER["REQUEST_URI"];
require_once("Models/salleModel.php");

if ($uri == "/index.php" || $uri == "/") {
    $salles = selectAllSalle($pdo);
    $template = "Views/salle/pageAccueil.php";
    $title = "Accueil";
} elseif ($uri == "/Salle") {
    $salles = selectAllSalle($pdo);
    $template = "Views/salle/pageSalle.php";
    $title = "Salle";
}

if (isset($template)) {
    require_once("Views/base.php");
}
