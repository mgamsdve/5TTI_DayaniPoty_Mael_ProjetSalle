<?php
// Liste tous les utilisateurs pour les écrans de consultation.
function selectAllUsers($pdo)
{
    try {
        // SELECT simple: on récupère toutes les colonnes de la table utilisateur.
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

function selectUserById($pdo, $idUser)
{
    try {
        // SELECT avec WHERE pour cibler un seul compte par son identifiant.
        $query = 'SELECT * FROM Utilisateur WHERE id_utilisateur = :idUser';
        $selectUser = $pdo->prepare($query);
        $selectUser->execute([
            "idUser" => $idUser
        ]);
        $user = $selectUser->fetch();
        return $user;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function selectUserByEmail($pdo, $email)
{
    try {
        // Recherche un compte par email pour vérifier l'unicité ou l'authentification.
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
        // INSERT d'un utilisateur classique avec mot de passe hashé.
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

function insertUserAdmin($pdo)
{
    try {
        // Variante admin de l'insertion: le rôle vient du formulaire de gestion.
        $query = 'INSERT INTO Utilisateur (uti_nom, uti_prenom, uti_email, uti_mdp, uti_role)
            VALUES (:nom, :prenom, :email, :mdp, :role)';
        $insertUser = $pdo->prepare($query);
        $insertUser->execute([
            "nom" => $_POST["nom"],
            "prenom" => $_POST["prenom"],
            "email" => $_POST["email"],
            "mdp" => password_hash($_POST["mdp"], PASSWORD_DEFAULT),
            "role" => $_POST["role"]
        ]);
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function selectUserByEmailAndPassword($pdo)
{
    try {
        // On récupère l'utilisateur par email puis on vérifie son mot de passe hashé.
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
        // Met à jour le profil du compte connecté sans toucher au rôle.
        $query = 'UPDATE utilisateur SET uti_nom = :nom, uti_prenom = :prenom, uti_email = :email
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

function updateUserAdmin($pdo, $idUser)
{
    try {
        // Mise à jour complète d'un compte par l'admin, y compris le rôle.
        $query = 'UPDATE Utilisateur
            SET uti_nom = :nom, uti_prenom = :prenom, uti_email = :email, uti_role = :role
            WHERE id_utilisateur = :idUser';
        $updateUser = $pdo->prepare($query);
        $updateUser->execute([
            "nom" => $_POST["nom"],
            "prenom" => $_POST["prenom"],
            "email" => $_POST["email"],
            "role" => $_POST["role"],
            "idUser" => $idUser
        ]);
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function updateUserAdminByGet($pdo)
{
    try {
        // Même logique que ci-dessus, mais la page admin envoie les données en GET.
        $idUser = (int) ($_GET["id_utilisateur"] ?? 0);

        $query = 'UPDATE Utilisateur
            SET uti_nom = :nom, uti_prenom = :prenom, uti_email = :email, uti_role = :role
            WHERE id_utilisateur = :idUser';
        $updateUser = $pdo->prepare($query);
        $updateUser->execute([
            "nom" => $_GET["nom"],
            "prenom" => $_GET["prenom"],
            "email" => $_GET["email"],
            "role" => $_GET["role"],
            "idUser" => $idUser
        ]);
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function updateSession($pdo)
{
    try {
        // Relit la ligne en base pour synchroniser les données en session.
        $query = 'SELECT * FROM Utilisateur WHERE id_utilisateur = :id';
        $selectUser = $pdo->prepare($query); //préparer la query
        $selectUser->execute([
            "id" => $_SESSION["user"]->id_utilisateur,
        ]); //exécuter la query
        $user = $selectUser->fetch(); //récupérer les donnés
        $_SESSION["user"] = $user;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function deleteUser($pdo)
{
    try {
        // Supprime le compte correspondant à l'utilisateur connecté.
        $query = 'DELETE FROM utilisateur WHERE id_utilisateur = :userId';
        $insertUser = $pdo->prepare($query); //préparer la query
        $insertUser->execute([
            "userId"   => $_SESSION["user"]->id_utilisateur
        ]); //exécuter la query
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function deleteUserById($pdo)
{
    try {
        // Supprime un compte précis à partir de l'id transmis dans la requête.
        $idUser = (int) ($_GET["id_utilisateur"] ?? 0);

        if ($idUser <= 0) {
            return;
        }

        $query = 'DELETE FROM Utilisateur WHERE id_utilisateur = :idUser';
        $deleteUser = $pdo->prepare($query);
        $deleteUser->execute([
            "idUser" => $idUser
        ]);
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

function deleteUsersByIds($pdo)
{
    try {
        // Supprime plusieurs utilisateurs en boucle à partir des cases cochées.
        $userIds = $_POST["user_ids"] ?? [];

        if (empty($userIds)) {
            return;
        }

        $query = 'DELETE FROM Utilisateur WHERE id_utilisateur = :idUser';
        $deleteUser = $pdo->prepare($query);

        foreach ($userIds as $id) {
            $deleteUser->execute([
                "idUser" => (int) $id
            ]);
        }
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}
