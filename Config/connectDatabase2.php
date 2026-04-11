<?php
try {
    // Connexion alternative vers une autre base de données du projet.
    $strConnection = "mysql:host=10.10.67.227;dbname=maeld;port=3306;";

    // Crée la connexion PDO réutilisable dans les modèles et contrôleurs.
    $pdo = new PDO(
        $strConnection,
        "MaelD", 
        "root",
        [
            // Les erreurs SQL remontent sous forme d'exceptions.
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // Les lignes récupérées sont manipulées comme des objets.
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ]
    );
} catch (PDOException $e) {
    // Un souci de connexion doit être visible immédiatement pour le débogage.
    $message = $e->getMessage();
    die($message);
}
