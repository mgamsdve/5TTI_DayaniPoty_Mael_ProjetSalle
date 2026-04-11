<?php

// Liste toutes les catégories pour remplir les selects et tableaux.
function selectAllCategories($pdo)
{
    try {
        // Tri alphabétique pour garder une présentation cohérente.
        $query = 'SELECT * FROM Categorie ORDER BY cat_nom';
        $selectCategories = $pdo->prepare($query);
        $selectCategories->execute();
        $categories = $selectCategories->fetchAll();
        return $categories;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function selectCategoryById($pdo, $idCategory)
{
    try {
        // Lit une catégorie précise à partir de son identifiant.
        $query = 'SELECT * FROM Categorie WHERE id_categorie = :idCategory';
        $selectCategory = $pdo->prepare($query); //preparer la query
        $selectCategory->execute([
            "idCategory" => $idCategory
        ]); //executer la query
        $category = $selectCategory->fetch(); //recuperer les donnees
        return $category;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function insertCategory($pdo)
{
    try {
        // Ajoute une nouvelle catégorie avec son nom.
        $query = 'INSERT INTO Categorie (cat_nom) VALUES (:nom)';
        $insertCategory = $pdo->prepare($query); //preparer la query
        $insertCategory->execute([
            "nom" => $_POST["nom"]
        ]); //executer la query
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function updateCategory($pdo, $idCategory)
{
    try {
        // Renomme la catégorie choisie par l'administration.
        $query = 'UPDATE Categorie SET cat_nom = :nom WHERE id_categorie = :idCategory';
        $updateCategory = $pdo->prepare($query); //preparer la query
        $updateCategory->execute([
            "nom" => $_POST["nom"],
            "idCategory" => $idCategory
        ]); //executer la query
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function deleteCategory($pdo, $idCategory)
{
    try {
        // Supprime la catégorie ciblée.
        $query = 'DELETE FROM Categorie WHERE id_categorie = :idCategory';
        $deleteCategory = $pdo->prepare($query); //preparer la query
        $deleteCategory->execute([
            "idCategory" => $idCategory
        ]); //executer la query
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}
