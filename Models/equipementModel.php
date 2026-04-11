<?php

// Liste tous les équipements disponibles.
function selectAllEquipements($pdo)
{
    try {
        // Tri alphabétique pour faciliter la lecture dans l'interface.
        $query = 'SELECT * FROM Equipement ORDER BY equi_nom';
        $selectEquipements = $pdo->prepare($query); //preparer la query
        $selectEquipements->execute(); //executer la query
        $equipements = $selectEquipements->fetchAll(); //recuperer les donnees
        return $equipements;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function selectEquipementById($pdo, $idEquipement)
{
    try {
        // Charge un équipement précis pour une modification ou une consultation.
        $query = 'SELECT * FROM Equipement WHERE id_equipement = :idEquipement';
        $selectEquipement = $pdo->prepare($query); //preparer la query
        $selectEquipement->execute([
            "idEquipement" => $idEquipement
        ]); //executer la query
        $equipement = $selectEquipement->fetch(); //recuperer les donnees
        return $equipement;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function insertEquipement($pdo)
{
    try {
        // Crée un nouvel équipement dans la table dédiée.
        $query = 'INSERT INTO Equipement (equi_nom, equi_description)
            VALUES (:nom, :description)';
        $insertEquipement = $pdo->prepare($query); //preparer la query
        $insertEquipement->execute([
            "nom" => $_POST["nom"],
            "description" => $_POST["description"]
        ]); //executer la query
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function updateEquipement($pdo, $idEquipement)
{
    try {
        // Met à jour le nom et la description d'un équipement.
        $query = 'UPDATE Equipement
            SET equi_nom = :nom, equi_description = :description
            WHERE id_equipement = :idEquipement';
        $updateEquipement = $pdo->prepare($query); //preparer la query
        $updateEquipement->execute([
            "nom" => $_POST["nom"],
            "description" => $_POST["description"],
            "idEquipement" => $idEquipement
        ]); //executer la query
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function deleteEquipement($pdo, $idEquipement)
{
    try {
        // Supprime l'équipement correspondant à l'identifiant transmis.
        $query = 'DELETE FROM Equipement WHERE id_equipement = :idEquipement';
        $deleteEquipement = $pdo->prepare($query); //preparer la query
        $deleteEquipement->execute([
            "idEquipement" => $idEquipement
        ]); //executer la query
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}
