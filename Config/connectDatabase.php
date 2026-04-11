<?php
try {
    // Chaîne de connexion vers la base locale utilisée pour le développement.
    $strConnection = "mysql:host=localhost;dbname=sys;port=3306";

    // Instancie PDO pour exécuter les requêtes SQL de l'application.
    $pdo = new PDO(
        $strConnection,
        "root",
        "root",
        [
            // Les erreurs SQL sont converties en exceptions pour être traitées proprement.
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // Les résultats sont renvoyés sous forme d'objets PHP.
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ]
    );
} catch (PDOException $e) {
    // Si la connexion échoue, on arrête l'application avec le message de diagnostic.
    $message = $e->getMessage();
    die($message);
}
