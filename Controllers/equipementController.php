<?php
$uri = $_SERVER["REQUEST_URI"];
require_once("Models/equipementModel.php");

if ($uri == "/Equipement") {
    $equipements = selectAllEquipements($pdo);
    $template = "Views/equipement/pageEquipement.php";
    $title = "Equipement";
}

if (isset($template)) {
    require_once("Views/base.php");
}
