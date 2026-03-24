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

    if (isset($_POST["action"]) && $_POST["action"] == "createReservation") {
        if (empty($_POST["id_salle"]) || empty($_POST["dateDebut"]) || empty($_POST["dateFin"])) {
            $erreurReservation = "Tous les champs sont obligatoires.";
        } elseif ($_POST["dateDebut"] >= $_POST["dateFin"]) {
            $erreurReservation = "La date de fin doit être après la date de début.";
        } else {
            $dateDebut = DateTime::createFromFormat("Y-m-d", $_POST["dateDebut"]);
            $dateFin = DateTime::createFromFormat("Y-m-d", $_POST["dateFin"]);

            if (!$dateDebut || !$dateFin) {
                $erreurReservation = "Format de date invalide.";
            } else {
                $dureeReservation = $dateDebut->diff($dateFin)->days;
                if ($dureeReservation > 5) {
                    $erreurReservation = "La durée maximale de réservation est de 5 jours.";
                } else {
                    insertReservation($pdo);
                    header("location:/Reservation");
                    exit;
                }
            }
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

    $idReservation = null;

    if (isset($_POST["action"]) && $_POST["action"] == "deleteReservation" && !empty($_POST["id_reservation"])) {
        $idReservation = $_POST["id_reservation"];
    } elseif (!empty($_GET["id"])) {
        // Fallback temporaire pour conserver la compatibilite avec les anciens liens.
        $idReservation = $_GET["id"];
    }

    if (!empty($idReservation)) {
        $reservation = selectReservationById($pdo, $idReservation);
        if ($reservation && $reservation->id_utilisateur == $_SESSION["user"]->id_utilisateur) {
            deleteReservation($pdo, $idReservation);
        }
    }

    header("location:/Reservation");
    exit;
}

if (isset($template)) {
    require_once("Views/base.php");
}
