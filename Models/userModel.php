<?php
function selectAllUsers($pdo)
{
    try {
        $query = 'select * from utilisateur';
        $selectUsers = $pdo->prepare($query); //préparer la query
        $selectUsers->execute(); //exécuter la query
        $users = $selectUsers->fetchAll(); //récupérer les donnés
        return $users;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}
function selectUserByEmail($pdo, $email)
{
    try {
        $query = 'SELECT * FROM Utilisateur WHERE uti_email = :email';
        $selectUsersEmail = $pdo->prepare($query); //préparer la query
        $selectUsersEmail->execute([
            "email" => $email
        ]); //exécuter la query
        $usersEmail = $selectUsersEmail->fetch(); //récupérer les donnés
        return $usersEmail;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}
function insertUser($pdo)
{
    try {
        $query = 'INSERT INTO Utilisateur (uti_nom, uti_prenom, uti_email, uti_mdp, uti_role)
            VALUES (:nom, :prenom, :email, :mdp, :role)';
        $insertUser = $pdo->prepare($query); //préparer la query
        $insertUser->execute([
            "nom"    => $_POST["nom"],
            "prenom" => $_POST["prenom"],
            "email"  => $_POST["email"],
            "mdp"    => password_hash($_POST["mdp"], PASSWORD_DEFAULT),
            "role"   => "utilisateur"
        ]); //exécuter la query
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function selectUserByEmailAndPassword($pdo)
{
    try {
        $query = 'SELECT * FROM Utilisateur WHERE uti_email = :email';
        $selectUser = $pdo->prepare($query); //préparer la query
        $selectUser->execute([
            "email" => $_POST["email"],
        ]); //exécuter la query
        $user = $selectUser->fetch(); //récupérer les donnés
        if ($user && password_verify($_POST["mdp"], $user->uti_mdp)) {
            return $user;
        }
        return false;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function updateUser($pdo)
{
    try {
        $query = 'UPDATE utilisateur set uti_nom = :nom, uti_prenom = :prenom, uti_email = :email
            WHERE id_utilisateur = :userId';
        $insertUser = $pdo->prepare($query); //préparer la query
        $insertUser->execute([
            "nom"    => $_POST["nom"],
            "prenom" => $_POST["prenom"],
            "email"  => $_POST["email"],
            "userId"   => $_SESSION["user"]->id_utilisateur
        ]); //exécuter la query
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}