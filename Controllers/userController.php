<?php
$uri = $_SERVER["REQUEST_URI"];
require_once("Models/userModel.php");

if ($uri == "/inscription") {
    $erreur = null;

    if (isset($_POST["envoyer"])) {

        if (
            empty($_POST["nom"]) ||
            empty($_POST["prenom"]) ||
            empty($_POST["email"]) ||
            empty($_POST["mdp"])
        ) {
            $erreur = "Tous les champs doivent être remplis";
        } else {
            $userExist = selectUserByEmail($pdo, $_POST["email"]);
            if (!$userExist) {
                insertUser($pdo);
                header("location:/connexion");
            } else {
                $erreur = "Cette adresse email est deja utilisé";
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
            $message = "Connecté";
        } else {
            $message = "Mauvais email ou MDP";
        }
    }
    $template = "Views/users/pageConnexion.php";
    $title = "Connexion";
}
