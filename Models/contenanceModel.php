<?php

function selectAllContenances($pdo)
{
    try {
        $query = 'SELECT Contenance.*, Equipement.equi_nom, Salle.sal_nom, Salle.sal_numero
            FROM Contenance
            INNER JOIN Equipement ON Equipement.id_equipement = Contenance.id_equipement
            INNER JOIN Salle ON Salle.id_salle = Contenance.id_salle
            ORDER BY Salle.sal_nom, Equipement.equi_nom';
        $selectContenances = $pdo->prepare($query);
        $selectContenances->execute();
        $contenances = $selectContenances->fetchAll();
        return $contenances;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function selectContenancesBySalleId($pdo, $idSalle)
{
    try {
        $query = 'SELECT Contenance.*, Equipement.equi_nom, Equipement.equi_description
            FROM Contenance
            INNER JOIN Equipement ON Equipement.id_equipement = Contenance.id_equipement
            WHERE Contenance.id_salle = :idSalle
            ORDER BY Equipement.equi_nom';
        $selectContenances = $pdo->prepare($query); //preparer la query
        $selectContenances->execute([
            "idSalle" => $idSalle
        ]); //executer la query
        $contenances = $selectContenances->fetchAll(); //recuperer les donnees
        return $contenances;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function insertContenance($pdo)
{
    try {
        $query = 'INSERT INTO Contenance (id_equipement, id_salle, cont_quantite)
            VALUES (:idEquipement, :idSalle, :quantite)';
        $insertContenance = $pdo->prepare($query); //preparer la query
        $insertContenance->execute([
            "idEquipement" => $_POST["id_equipement"],
            "idSalle" => $_POST["id_salle"],
            "quantite" => $_POST["quantite"]
        ]); //executer la query
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function updateContenance($pdo, $idContenance)
{
    try {
        $query = 'UPDATE Contenance
            SET id_equipement = :idEquipement, id_salle = :idSalle, cont_quantite = :quantite
            WHERE id_contenance = :idContenance';
        $updateContenance = $pdo->prepare($query); //preparer la query
        $updateContenance->execute([
            "idEquipement" => $_POST["id_equipement"],
            "idSalle" => $_POST["id_salle"],
            "quantite" => $_POST["quantite"],
            "idContenance" => $idContenance
        ]); //executer la query
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function deleteContenance($pdo, $idContenance)
{
    try {
        $query = 'DELETE FROM Contenance WHERE id_contenance = :idContenance';
        $deleteContenance = $pdo->prepare($query); //preparer la query
        $deleteContenance->execute([
            "idContenance" => $idContenance
        ]); //executer la query
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}
