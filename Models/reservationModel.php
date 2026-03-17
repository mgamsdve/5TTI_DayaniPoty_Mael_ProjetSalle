<?php

function selectAllReservations($pdo)
{
    try {
        $query = 'SELECT Reservation.*, Salle.sal_nom, Salle.sal_image, Utilisateur.uti_nom, Utilisateur.uti_prenom
            FROM Reservation
            INNER JOIN Salle ON Salle.id_salle = Reservation.id_salle
            INNER JOIN Utilisateur ON Utilisateur.id_utilisateur = Reservation.id_utilisateur
            ORDER BY Reservation.res_dateDebut DESC';
        $selectReservations = $pdo->prepare($query); //preparer la query
        $selectReservations->execute(); //executer la query
        $reservations = $selectReservations->fetchAll(); //recuperer les donnees
        return $reservations;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function selectReservationById($pdo, $idReservation)
{
    try {
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

function updateReservation($pdo, $idReservation)
{
    try {
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

function deleteReservation($pdo, $idReservation)
{
    try {
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
