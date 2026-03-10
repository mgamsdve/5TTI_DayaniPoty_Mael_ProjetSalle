<?php
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
require_once("Models/reservationModel.php");
require_once("Models/salleModel.php");

if ($uri == "/Reservation") {
    if (!isset($_SESSION["user"])) {
        header("location:/connexion");
        exit;
    }

    $reservations = selectReservationsByUserId($pdo, $_SESSION["user"]->id_utilisateur);
    $template = "Views/reservation/pageReservation.php";
    $title = "Mes Réservations";
}

if ($uri == "/create-reservation") {
    if (!isset($_SESSION["user"])) {
        header("location:/connexion");
        exit;
    }

    $erreurReservation = null;

    if (isset($_POST["creerReservation"])) {
        if (empty($_POST["id_salle"]) || empty($_POST["dateDebut"]) || empty($_POST["dateFin"])) {
            $erreurReservation = "Tous les champs sont obligatoires.";
        } elseif ($_POST["dateDebut"] >= $_POST["dateFin"]) {
            $erreurReservation = "La date de fin doit être après la date de début.";
        } else {
            insertReservation($pdo);
            header("location:/Reservation");
            exit;
        }
    }

    $salles = selectAllSalle($pdo);
    $template = "Views/reservation/pageCreerReservation.php";
    $title = "Nouvelle réservation";
}

// Suppression d'une réservation
if ($uri == "/delete-reservation") {
    if (!isset($_SESSION["user"])) {
        header("location:/connexion");
        exit;
    }

    $idReservation = $_GET["id"];
    $reservation = selectReservationById($pdo, $idReservation);
    if ($reservation && $reservation->id_utilisateur == $_SESSION["user"]->id_utilisateur) {
        deleteReservation($pdo, $idReservation);
    }
    header("location:/Reservation");
    exit;
}

if (isset($template)) {
    require_once("Views/base.php");
}
