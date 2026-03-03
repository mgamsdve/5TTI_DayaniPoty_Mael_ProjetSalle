<?php
function selectAllSalle($pdo)
{
    try {
        $query = 'select * from salle';
        $selectSalle = $pdo->prepare($query); //préparer la query
        $selectSalle->execute(); //exécuter la query
        $salles = $selectSalle->fetchAll(); //récupérer les donnés
        return $salles;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function selectSalleById($pdo, $idSalle)
{
    try {
        $query = 'SELECT * FROM Salle WHERE id_salle = :idSalle';
        $selectSalle = $pdo->prepare($query); //preparer la query
        $selectSalle->execute([
            "idSalle" => $idSalle
        ]); //executer la query
        $salle = $selectSalle->fetch(); //recuperer les donnees
        return $salle;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function selectSallesByCategorieId($pdo, $idCategorie)
{
    try {
        $query = 'SELECT * FROM Salle WHERE id_categorie = :idCategorie ORDER BY sal_nom';
        $selectSalles = $pdo->prepare($query); //preparer la query
        $selectSalles->execute([
            "idCategorie" => $idCategorie
        ]); //executer la query
        $salles = $selectSalles->fetchAll(); //recuperer les donnees
        return $salles;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function insertSalle($pdo)
{
    try {
        $query = 'INSERT INTO Salle (id_categorie, sal_nom, sal_taille, sal_numero, sal_image)
            VALUES (:idCategorie, :nom, :taille, :numero, :image)';
        $insertSalle = $pdo->prepare($query); //preparer la query
        $insertSalle->execute([
            "idCategorie" => $_POST["id_categorie"],
            "nom" => $_POST["nom"],
            "taille" => $_POST["taille"],
            "numero" => $_POST["numero"],
            "image" => $_POST["image"]
        ]); //executer la query
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function updateSalle($pdo, $idSalle)
{
    try {
        $query = 'UPDATE Salle
            SET id_categorie = :idCategorie, sal_nom = :nom, sal_taille = :taille, sal_numero = :numero, sal_image = :image
            WHERE id_salle = :idSalle';
        $updateSalle = $pdo->prepare($query); //preparer la query
        $updateSalle->execute([
            "idCategorie" => $_POST["id_categorie"],
            "nom" => $_POST["nom"],
            "taille" => $_POST["taille"],
            "numero" => $_POST["numero"],
            "image" => $_POST["image"],
            "idSalle" => $idSalle
        ]); //executer la query
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function deleteSalle($pdo, $idSalle)
{
    try {
        $query = 'DELETE FROM Salle WHERE id_salle = :idSalle';
        $deleteSalle = $pdo->prepare($query); //preparer la query
        $deleteSalle->execute([
            "idSalle" => $idSalle
        ]); //executer la query
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}
