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
