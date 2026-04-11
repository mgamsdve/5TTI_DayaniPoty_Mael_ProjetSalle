<?php
// Lit l'URL pour router l'utilisateur vers la bonne page.
$uri = $_SERVER["REQUEST_URI"];
// Charge les fonctions SQL liées aux comptes utilisateurs.
require_once("Models/userModel.php");

if ($uri == "/inscription") {
    // La page inscription doit d'abord traiter un éventuel envoi du formulaire.
    if (isset($_POST["envoyer"])) {

        // Vérifie côté serveur qu'aucun champ important n'est vide.
        $messageError = verifEmptyData();

        if (!$messageError) {

            // Empêche les doublons d'email dans la table utilisateur.
            $userExist = selectUserByEmail($pdo, $_POST["email"]);

            if ($userExist === false) {
                // Si l'email est libre, on crée le compte.
                insertUser($pdo);
                // La redirection amène ensuite l'utilisateur vers la connexion.
                header("location:/connexion");
                exit;
            } else {
                // Message explicite pour expliquer pourquoi l'inscription est refusée.
                $messageError = [];
                $messageError["email"] = "Cette adresse email est déjà utilisée.";
            }
        }
    }

    $title = "Inscription";
    $template = "Views/users/pageInscription.php";
} elseif ($uri == "/Utilisateur") {
    // Charge la liste des utilisateurs pour la page publique dédiée.
    $users = selectAllUsers($pdo);
    $template = "Views/users/pageUtilisateur.php";
    $title = "Utilisateurs";
} elseif ($uri == "/connexion") {
    // Message d'état utilisé par la vue de connexion.
    $message = null;
    if (isset($_POST["envoyer"])) {
        // Compare les identifiants saisis avec ceux stockés en base.
        $user = selectUserByEmailAndPassword($pdo);
        if ($user) {
            // Conserve l'utilisateur en session pour le reconnaître sur les pages protégées.
            $_SESSION["user"] = $user;
            header("location:/");
            $message = "Connecté";
        } else {
            // On évite de préciser si le problème vient de l'email ou du mot de passe.
            $message = "Mauvais email ou MDP";
        }
    }
    $template = "Views/users/pageConnexion.php";
    $title = "Connexion";
} elseif ($uri == "/deconnexion") {
    // Ferme complètement la session active.
    session_destroy();
    header("location:/");
} elseif ($uri == "/Profil") {
    // La page profil permet de modifier les informations du compte connecté.
    if (isset($_POST["envoyer"])) {

        // Vérifie que les champs indispensables ont bien été remplis.
        if (
            empty($_POST["nom"]) ||
            empty($_POST["prenom"]) ||
            empty($_POST["email"])
        ) {
            // On stoppe la mise à jour si le formulaire est incomplet.
            $erreur = "Tous les champs doivent être remplis";
        } else {
            // Met à jour la ligne du compte connecté dans la base.
            updateUser($pdo);
            // Recharge la session pour afficher les nouvelles valeurs sans attendre.
            updateSession($pdo);
            header("location:/Profil");
        }
    }

    $template = "Views/users/pageProfil.php";
    $title = "Mon Profil";
} elseif ($uri == "/deleteProfil") {
    // Supprime le compte du membre connecté puis termine la session.
    deleteUser($pdo);
    session_destroy();
    header("location:/");
    $template = "Views/users/pageProfil.php";
    $title = "Mon Profil";
}


function verifEmptyData()
{
    // Parcourt tous les champs reçus pour repérer ceux qui sont vides.
    foreach ($_POST as $key => $value) {
        if (empty(str_replace(' ', '', $value))) {
            // Construit un message spécifique au champ concerné.
            $messageError[$key] = "Votre " . $key . " est vide.";
        }
    }

    if (isset($messageError)) {
        // Si au moins une erreur existe, on renvoie la liste complète.
        return $messageError;
    } else {
        // Sinon, on signale que la validation est réussie.
        return false;
    }
}

if (isset($template)) {
    // Injecte la vue choisie dans le layout commun.
    require_once("Views/base.php");
}
