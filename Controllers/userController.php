<?php
$uri = $_SERVER["REQUEST_URI"];
require_once("Models/userModel.php");

if ($uri == "/inscription") {
    if (isset($_POST["envoyer"])) {

        $messageError = verifEmptyData();

        if (!$messageError) {

            $userExist = selectUserByEmail($pdo, $_POST["email"]);

            if ($userExist === false) {
                insertUser($pdo);
                header("location:/connexion");
                exit;
            } else {
                $messageError = [];
                $messageError["email"] = "Cette adresse email est déjà utilisée.";
            }
        }
    }

    $title = "Inscription";
    $template = "Views/users/pageInscription.php";
} elseif ($uri == "/Utilisateur") {
    $users = selectAllUsers($pdo);
    $template = "Views/users/pageUtilisateur.php";
    $title = "Utilisateurs";
} elseif ($uri == "/connexion") {
    $message = null;
    if (isset($_POST["envoyer"])) {
        $user = selectUserByEmailAndPassword($pdo);
        if ($user) {
            $_SESSION["user"] = $user;
            header("location:/");
            $message = "Connecté";
        } else {
            $message = "Mauvais email ou MDP";
        }
    }
    $template = "Views/users/pageConnexion.php";
    $title = "Connexion";
} elseif ($uri == "/deconnexion") {
    session_destroy();
    header("location:/");
} elseif ($uri == "/Profil") {
    if (isset($_POST["envoyer"])) {

        if (
            empty($_POST["nom"]) ||
            empty($_POST["prenom"]) ||
            empty($_POST["email"])
        ) {
            $erreur = "Tous les champs doivent être remplis";
        } else {
            updateUser($pdo);
            updateSession($pdo);
            header("location:/Profil");
        }
    }

    $template = "Views/users/pageProfil.php";
    $title = "Mon Profil";
} elseif ($uri == "/deleteProfil") {
    deleteUser($pdo);
    session_destroy();
    header("location:/");
    $template = "Views/users/pageProfil.php";
    $title = "Mon Profil";
}


function verifEmptyData()
{
    foreach ($_POST as $key => $value) {
        if (empty(str_replace(' ', '', $value))) {
            $messageError[$key] = "Votre " . $key . " est vide.";
        }
    }

    if (isset($messageError)) {
        return $messageError;
    } else {
        return false;
    }
}

if (isset($template)) {
    require_once("Views/base.php");
}
