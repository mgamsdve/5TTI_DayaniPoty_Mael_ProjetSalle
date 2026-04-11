<?php
// Retourne une image aléatoire pour éviter de devoir saisir une image à la main.
function getRandomSalleImageUrl()
{
    // Liste d'images publiques prêtes à l'emploi pour illustrer les salles.
    $images = [
        'https://images.unsplash.com/photo-1497366811353-6870744d04b2?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'https://images.unsplash.com/photo-1497366754035-f200968a6e72?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'https://images.unsplash.com/photo-1497366412874-3415097a27e7?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'https://images.unsplash.com/photo-1454165205744-3b78555e5572?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'https://images.unsplash.com/photo-1524758631624-e2822e304c36?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'https://images.unsplash.com/photo-1469474968028-56623f02e42e?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'https://images.unsplash.com/photo-1493666438817-866a91353ca9?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'https://images.unsplash.com/photo-1517048676732-d65bc937f952?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'https://images.unsplash.com/photo-1489515217757-5fd1be406fef?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'https://images.unsplash.com/photo-1487014679447-9f8336841d58?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'https://images.unsplash.com/photo-1484154218962-a197022b5858?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'https://images.unsplash.com/photo-1464938050520-ef2270bb8ce8?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'https://images.unsplash.com/photo-1517502884422-41eaead166d4?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
    ];

    return $images[array_rand($images)];
}

function selectAllSalle($pdo)
{
    try {
        // Récupère toutes les salles sans filtre pour les pages publiques et admin.
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

function selectSallesByCategorieId($pdo, $idCategorie)
{
    try {
        // Filtre les salles en fonction de leur catégorie.
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
        // Ajoute une salle avec une image générée automatiquement.
        $query = 'INSERT INTO Salle (id_categorie, sal_nom, sal_taille, sal_numero, sal_image)
            VALUES (:idCategorie, :nom, :taille, :numero, :image)';
        $insertSalle = $pdo->prepare($query); //preparer la query
        $insertSalle->execute([
            "idCategorie" => $_POST["id_categorie"],
            "nom" => $_POST["nom"],
            "taille" => $_POST["taille"],
            "numero" => $_POST["numero"],
            "image" => getRandomSalleImageUrl()
        ]); //executer la query
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function updateSalle($pdo, $idSalle)
{
    try {
        // Met à jour les informations principales d'une salle existante.
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
        // Supprime une salle via son identifiant primaire.
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

function deleteSallesByIds($pdo)
{
    try {
        // Supprime plusieurs salles à partir des identifiants sélectionnés.
        $salleIds = $_POST["salle_ids"] ?? [];

        if (empty($salleIds)) {
            return;
        }

        $query = 'DELETE FROM Salle WHERE id_salle = :idSalle';
        $deleteSalle = $pdo->prepare($query);

        foreach ($salleIds as $idSalle) {
            $deleteSalle->execute([
                "idSalle" => (int) $idSalle
            ]);
        }
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function selectSalleByNumero($pdo, $numeroSalle)
{
    try {
        // Cherche une salle via son numéro lisible dans l'URL de détail.
        $query = 'SELECT * FROM Salle WHERE sal_numero = :numeroSalle';
        $selectSalle = $pdo->prepare($query); //preparer la query
        $selectSalle->execute([
            "numeroSalle" => $numeroSalle
        ]); //executer la query
        $salle = $selectSalle->fetch(); //recuperer les donnees
        return $salle;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}
