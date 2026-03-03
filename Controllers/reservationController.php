<?php
$uri = $_SERVER["REQUEST_URI"];
require_once("Models/reservationModel.php");

if ($uri == "/Reservation") {
    if (!isset($_SESSION["user"])) {
        header("location:/connexion");
        exit;
    }

    $reservations = selectReservationsByUserId($pdo, $_SESSION["user"]->id_utilisateur);
    $template = "Views/reservation/pageReservation.php";
    $title = "Reservation";
}

if (isset($template)) {
    require_once("Views/base.php");
}
