<?php

// Récupère toutes les réservations avec les informations des FK pour l'admin.
function selectAllReservations($pdo)
{
    try {
        // JOIN entre Reservation, Salle et Utilisateur pour enrichir l'affichage.
        $query = 'SELECT Reservation.*, Salle.sal_nom, Salle.sal_numero, Utilisateur.uti_nom, Utilisateur.uti_prenom
            FROM Reservation
            INNER JOIN Salle ON Salle.id_salle = Reservation.id_salle
            INNER JOIN Utilisateur ON Utilisateur.id_utilisateur = Reservation.id_utilisateur
            ORDER BY Reservation.res_dateDebut DESC';
        $selectReservations = $pdo->prepare($query);
        $selectReservations->execute();
        $reservations = $selectReservations->fetchAll();
        return $reservations;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function selectReservationById($pdo, $idReservation)
{
    try {
        // Lit une seule réservation à partir de son identifiant.
        $query = 'SELECT * FROM Reservation WHERE id_reservation = :idReservation';
        $selectReservation = $pdo->prepare($query); //preparer la query
        $selectReservation->execute([
            "idReservation" => $idReservation
        ]); //executer la query
        $reservation = $selectReservation->fetch(); //recuperer les donnees
        return $reservation;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function selectReservationsByUserId($pdo, $idUtilisateur)
{
    try {
        // Filtre les réservations d'un utilisateur pour la page "Mes réservations".
        $query = 'SELECT Reservation.*, Salle.sal_nom, Salle.sal_image, Salle.sal_numero
            FROM Reservation
            INNER JOIN Salle ON Salle.id_salle = Reservation.id_salle
            WHERE Reservation.id_utilisateur = :idUtilisateur
            ORDER BY Reservation.res_dateDebut DESC';
        $selectReservations = $pdo->prepare($query); //preparer la query
        $selectReservations->execute([
            "idUtilisateur" => $idUtilisateur
        ]); //executer la query
        $reservations = $selectReservations->fetchAll(); //recuperer les donnees
        return $reservations;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function selectReservationsBySalleId($pdo, $idSalle)
{
    try {
        // Récupère les réservations liées à une salle précise.
        $query = 'SELECT Reservation.*, Salle.sal_nom, Salle.sal_image, Utilisateur.uti_nom, Utilisateur.uti_prenom
            FROM Reservation
            INNER JOIN Salle ON Salle.id_salle = Reservation.id_salle
            INNER JOIN Utilisateur ON Utilisateur.id_utilisateur = Reservation.id_utilisateur
            WHERE Reservation.id_salle = :idSalle
            ORDER BY Reservation.res_dateDebut DESC';
        $selectReservations = $pdo->prepare($query); //preparer la query
        $selectReservations->execute([
            "idSalle" => $idSalle
        ]); //executer la query
        $reservations = $selectReservations->fetchAll(); //recuperer les donnees
        return $reservations;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function insertReservation($pdo)
{
    try {
        // Insère une réservation simple liée à l'utilisateur connecté.
        $userId = $_SESSION["user"]->id_utilisateur;
        $query = 'INSERT INTO Reservation (id_salle, id_utilisateur, res_dateDebut, res_dateFin)
            VALUES (:idSalle, :idUtilisateur, :dateDebut, :dateFin)';
        $insertReservation = $pdo->prepare($query); //preparer la query
        $insertReservation->execute([
            "idSalle" => $_POST["id_salle"],
            "idUtilisateur" => $userId,
            "dateDebut" => $_POST["dateDebut"],
            "dateFin" => $_POST["dateFin"]
        ]); //executer la query
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function insertReservationsMultiForUser($pdo)
{
    try {
        // Prépare une insertion répétée pour créer une réservation par salle sélectionnée.
        $idSalles = $_POST["id_salles"] ?? [];
        $idUtilisateur = (int) $_SESSION["user"]->id_utilisateur;
        $dateDebut = $_POST["dateDebut"] ?? "";
        $dateFin = $_POST["dateFin"] ?? "";

        if (empty($idSalles)) {
            return;
        }

        $query = 'INSERT INTO Reservation (id_salle, id_utilisateur, res_dateDebut, res_dateFin)
            VALUES (:idSalle, :idUtilisateur, :dateDebut, :dateFin)';
        $insertReservation = $pdo->prepare($query);

        foreach ($idSalles as $idSalle) {
            $insertReservation->execute([
                "idSalle" => (int) $idSalle,
                "idUtilisateur" => $idUtilisateur,
                "dateDebut" => $dateDebut,
                "dateFin" => $dateFin
            ]);
        }
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function updateReservation($pdo, $idReservation)
{
    try {
        // Met à jour les champs principaux d'une réservation utilisateur.
        $query = 'UPDATE Reservation
            SET id_salle = :idSalle, res_dateDebut = :dateDebut, res_dateFin = :dateFin
            WHERE id_reservation = :idReservation';
        $updateReservation = $pdo->prepare($query); //preparer la query
        $updateReservation->execute([
            "idSalle" => $_POST["id_salle"],
            "dateDebut" => $_POST["dateDebut"],
            "dateFin" => $_POST["dateFin"],
            "idReservation" => $idReservation
        ]); //executer la query
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function insertReservationAdmin($pdo)
{
    try {
        // Version admin de l'insertion: l'utilisateur concerné est choisi dans le formulaire.
        $query = 'INSERT INTO Reservation (id_salle, id_utilisateur, res_dateDebut, res_dateFin)
            VALUES (:idSalle, :idUtilisateur, :dateDebut, :dateFin)';
        $insertReservation = $pdo->prepare($query);
        $insertReservation->execute([
            "idSalle" => $_POST["id_salle"],
            "idUtilisateur" => $_POST["id_utilisateur"],
            "dateDebut" => $_POST["dateDebut"],
            "dateFin" => $_POST["dateFin"]
        ]);
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function updateReservationAdmin($pdo, $idReservation)
{
    try {
        // Met à jour une réservation avec la salle, l'utilisateur et les dates.
        $query = 'UPDATE Reservation
            SET id_salle = :idSalle, id_utilisateur = :idUtilisateur, res_dateDebut = :dateDebut, res_dateFin = :dateFin
            WHERE id_reservation = :idReservation';
        $updateReservation = $pdo->prepare($query);
        $updateReservation->execute([
            "idSalle" => $_POST["id_salle"],
            "idUtilisateur" => $_POST["id_utilisateur"],
            "dateDebut" => $_POST["dateDebut"],
            "dateFin" => $_POST["dateFin"],
            "idReservation" => $idReservation
        ]);
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function deleteReservation($pdo, $idReservation)
{
    try {
        // Supprime une réservation identifiée par son id.
        $query = 'DELETE FROM Reservation WHERE id_reservation = :idReservation';
        $deleteReservation = $pdo->prepare($query); //preparer la query
        $deleteReservation->execute([
            "idReservation" => $idReservation
        ]); //executer la query
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}
