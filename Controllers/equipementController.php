<?php
// Récupère l'URL telle qu'elle a été demandée par le navigateur.
$uri = $_SERVER["REQUEST_URI"];
// Charge le modèle des équipements.
require_once("Models/equipementModel.php");

if ($uri == "/Equipement") {
    // Affiche la liste complète des équipements.
    $equipements = selectAllEquipements($pdo);
    $template = "Views/equipement/pageEquipement.php";
    $title = "Equipement";
}

if (isset($template)) {
    // Passe par le layout principal pour garder l'interface homogène.
    require_once("Views/base.php");
}
