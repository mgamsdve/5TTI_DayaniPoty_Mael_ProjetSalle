<?php
try {
    $strConnection = "mysql:host=10.10.67.227;dbname=maeld;port=3306;";

    $pdo = new PDO(
        $strConnection,
        "MaelD", 
        "root",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ]
    );
} catch (PDOException $e) {
    $message = $e->getMessage();
    die($message);
}
