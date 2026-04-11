<?php
// Récupère le chemin de l'URL pour router les actions liées aux réservations.
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
// Charge les modèles utilisés pour lire ou modifier les réservations.
require_once("Models/reservationModel.php");
require_once("Models/salleModel.php");

if ($uri == "/Reservation") {
    // La page réservations est réservée aux utilisateurs connectés.
    if (!isset($_SESSION["user"])) {
        header("location:/connexion");
        exit;
    }

    // Filtre les réservations sur l'identifiant de l'utilisateur connecté.
    $reservations = selectReservationsByUserId($pdo, $_SESSION["user"]->id_utilisateur);
    $template = "Views/reservation/pageReservation.php";
    $title = "Mes Réservations";
}

if ($uri == "/create-reservation") {
    // La création de réservation est aussi protégée par l'authentification.
    if (!isset($_SESSION["user"])) {
        header("location:/connexion");
        exit;
    }

    // Sert à afficher un message clair si la validation échoue.
    $erreurReservation = null;

    if (isset($_POST["action"]) && $_POST["action"] == "createReservation") {
        // Le formulaire permet de réserver plusieurs salles sur une seule période.
        if (empty($_POST["id_salles"]) || empty($_POST["dateDebut"]) || empty($_POST["dateFin"])) {
            // Bloque l'envoi si un champ essentiel est manquant.
            $erreurReservation = "Tous les champs sont obligatoires.";
        } elseif ($_POST["dateDebut"] >= $_POST["dateFin"]) {
            // La date de fin doit obligatoirement être postérieure à la date de début.
            $erreurReservation = "La date de fin doit être après la date de début.";
        } else {
            // Convertit les chaînes en objets DateTime pour vérifier le format et la durée.
            $dateDebut = DateTime::createFromFormat("Y-m-d", $_POST["dateDebut"]);
            $dateFin = DateTime::createFromFormat("Y-m-d", $_POST["dateFin"]);

            if (!$dateDebut || !$dateFin) {
                // Signale un format de date invalide.
                $erreurReservation = "Format de date invalide.";
            } else {
                // Calcule la durée de réservation pour appliquer la règle métier.
                $dureeReservation = $dateDebut->diff($dateFin)->days;
                if ($dureeReservation > 5) {
                    // La durée maximale est limitée pour éviter les réservations trop longues.
                    $erreurReservation = "La durée maximale de réservation est de 5 jours.";
                } else {
                    // Crée une réservation par salle sélectionnée.
                    insertReservationsMultiForUser($pdo);
                    header("location:/Reservation");
                    exit;
                }
            }
        }
    }

    // Charge les salles pour alimenter le multi-select du formulaire.
    $salles = selectAllSalle($pdo);
    $template = "Views/reservation/pageCreerReservation.php";
    $title = "Nouvelle réservation";
}

// Suppression d'une réservation
if ($uri == "/delete-reservation") {
    // La suppression doit aussi être effectuée par un utilisateur connecté.
    if (!isset($_SESSION["user"])) {
        header("location:/connexion");
        exit;
    }

    // Va contenir l'identifiant de la réservation à supprimer.
    $idReservation = null;

    if (isset($_POST["action"]) && $_POST["action"] == "deleteReservation" && !empty($_POST["id_reservation"])) {
        // Cas standard: suppression déclenchée par le formulaire POST.
        $idReservation = $_POST["id_reservation"];
    } elseif (!empty($_GET["id"])) {
        // Fallback temporaire pour rester compatible avec d'anciens liens GET.
        $idReservation = $_GET["id"];
    }

    if (!empty($idReservation)) {
        // Vérifie que la réservation appartient bien au compte connecté avant de la supprimer.
        $reservation = selectReservationById($pdo, $idReservation);
        if ($reservation && $reservation->id_utilisateur == $_SESSION["user"]->id_utilisateur) {
            deleteReservation($pdo, $idReservation);
        }
    }

    header("location:/Reservation");
    exit;
}

if (isset($template)) {
    // Charge le layout principal avec la vue préparée par le contrôleur.
    require_once("Views/base.php");
}
