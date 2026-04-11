<?php
// Récupère le chemin de la requête pour router l'administration.
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
// Découpe l'URL pour traiter les routes de détail.
$segments = explode("/", trim($uri, "/"));

// Charge tous les modèles nécessaires au back-office.
require_once("Models/userModel.php");
require_once("Models/salleModel.php");
require_once("Models/equipementModel.php");
require_once("Models/reservationModel.php");
require_once("Models/contenanceModel.php");
require_once("Models/categorieModel.php");

if (strpos($uri, "/admin") === 0) {
    // Toute route admin exige une session ouverte.
    if (!isset($_SESSION["user"])) {
        header("location:/connexion");
        exit;
    }

    // Seuls les comptes admin peuvent accéder à cette zone.
    if ($_SESSION["user"]->uti_role != "admin") {
        header("location:/");
        exit;
    }
}

if ($uri == "/admin") {
    // Le dashboard centralise les liens vers les modules d'administration.
    $template = "Views/admin/pageAdmin.php";
    $title = "Administration";
}

if ($uri == "/admin/users") {
    // Cette page gère l'affichage, la modification et la suppression des comptes.
    if (isset($_GET["action"])) {
        if ($_GET["action"] == "updateUserGet" && !empty($_GET["id_utilisateur"])) {
            // Vérifie que toutes les données utiles sont présentes avant la mise à jour.
            if (
                !empty($_GET["nom"]) &&
                !empty($_GET["prenom"]) &&
                !empty($_GET["email"]) &&
                !empty($_GET["role"])
            ) {
                // La mise à jour en GET répond au besoin spécifique demandé dans le projet.
                updateUserAdminByGet($pdo);
                if ($_SESSION["user"]->id_utilisateur == (int) $_GET["id_utilisateur"]) {
                    // Si l'admin modifie son propre compte, la session doit être actualisée.
                    updateSession($pdo);
                }
            }

            header("location:/admin/users");
            exit;
        }

        if ($_GET["action"] == "deleteUserGet" && !empty($_GET["id_utilisateur"])) {
            // Récupère l'identifiant à supprimer.
            $idUser = (int) $_GET["id_utilisateur"];

            // Empêche de supprimer le compte actuellement connecté.
            if ($idUser > 0 && $idUser != (int) $_SESSION["user"]->id_utilisateur) {
                deleteUserById($pdo);
            }

            header("location:/admin/users");
            exit;
        }
    }

    if (isset($_POST["action"])) {
        if ($_POST["action"] == "addUser") {
            // Ajoute un utilisateur depuis le back-office.
            insertUserAdmin($pdo);
        } elseif ($_POST["action"] == "deleteUsersMulti" && !empty($_POST["user_ids"])) {
            // Supprime plusieurs utilisateurs cochés dans le tableau.
            deleteUsersByIds($pdo);
        }

        header("location:/admin/users");
        exit;
    }

    // Charge tous les comptes pour alimenter la table admin.
    $users = selectAllUsers($pdo);
    $template = "Views/admin/pageAdminUsers.php";
    $title = "Admin Utilisateurs";
}

if (
    count($segments) >= 4 &&
    $segments[0] == "admin" &&
    $segments[1] == "users" &&
    $segments[2] == "details"
) {
    // La route détail reçoit l'id directement dans le chemin.
    $idUser = (int) $segments[3];
    // Charge la fiche utilisateur à afficher.
    $userDetails = selectUserById($pdo, $idUser);
    $userReservations = [];

    if ($userDetails) {
        // Charge aussi les réservations associées pour contextualiser la fiche.
        $userReservations = selectReservationsByUserId($pdo, $userDetails->id_utilisateur);
    }

    $template = "Views/admin/pageAdminUserDetails.php";
    $title = "Detail Utilisateur";
}

if ($uri == "/admin/categories") {
    if (isset($_POST["action"])) {
        if ($_POST["action"] == "addCategory") {
            // Crée une nouvelle catégorie.
            insertCategory($pdo);
        } elseif ($_POST["action"] == "updateCategory") {
            // Renomme une catégorie existante.
            updateCategory($pdo, $_POST["id_categorie"]);
        } elseif ($_POST["action"] == "deleteCategory") {
            // Supprime une catégorie.
            deleteCategory($pdo, $_POST["id_categorie"]);
        }

        header("location:/admin/categories");
        exit;
    }

    // Charge la liste des catégories pour le tableau.
    $categories = selectAllCategories($pdo);
    $template = "Views/admin/pageAdminCategories.php";
    $title = "Admin Categories";
}

if ($uri == "/admin/salles") {
    if (isset($_POST["action"])) {
        if ($_POST["action"] == "addSalle") {
            // Ajoute une salle et lui associe une catégorie.
            insertSalle($pdo);
        } elseif ($_POST["action"] == "deleteSallesMulti" && !empty($_POST["salle_ids"])) {
            // Supprime plusieurs salles d'un seul coup.
            deleteSallesByIds($pdo);
        } elseif ($_POST["action"] == "updateSalle") {
            // Met à jour une salle précise.
            updateSalle($pdo, $_POST["id_salle"]);
        } elseif ($_POST["action"] == "deleteSalle") {
            // Supprime une seule salle.
            deleteSalle($pdo, $_POST["id_salle"]);
        }

        header("location:/admin/salles");
        exit;
    }

    // Les deux listes sont nécessaires pour remplir les selects et le tableau.
    $categories = selectAllCategories($pdo);
    $salles = selectAllSalle($pdo);
    $template = "Views/admin/pageAdminSalles.php";
    $title = "Admin Salles";
}

if ($uri == "/admin/equipements") {
    if (isset($_POST["action"])) {
        if ($_POST["action"] == "addEquipement") {
            // Ajoute un nouvel équipement au catalogue.
            insertEquipement($pdo);
        } elseif ($_POST["action"] == "updateEquipement") {
            // Modifie un équipement existant.
            updateEquipement($pdo, $_POST["id_equipement"]);
        } elseif ($_POST["action"] == "deleteEquipement") {
            // Supprime un équipement.
            deleteEquipement($pdo, $_POST["id_equipement"]);
        }

        header("location:/admin/equipements");
        exit;
    }

    // Liste tous les équipements pour l'administration.
    $equipements = selectAllEquipements($pdo);
    $template = "Views/admin/pageAdminEquipements.php";
    $title = "Admin Equipements";
}

if ($uri == "/admin/contenances") {
    if (isset($_POST["action"])) {
        if ($_POST["action"] == "addContenance") {
            // Crée une relation salle-équipement avec une quantité.
            insertContenance($pdo);
        } elseif ($_POST["action"] == "updateContenance") {
            // Met à jour cette relation.
            updateContenance($pdo, $_POST["id_contenance"]);
        } elseif ($_POST["action"] == "deleteContenance") {
            // Supprime la relation demandée.
            deleteContenance($pdo, $_POST["id_contenance"]);
        }

        header("location:/admin/contenances");
        exit;
    }

    // Charge les données des deux tables liées plus le tableau de relation.
    $salles = selectAllSalle($pdo);
    $equipements = selectAllEquipements($pdo);
    $contenances = selectAllContenances($pdo);
    $template = "Views/admin/pageAdminContenances.php";
    $title = "Admin Contenances";
}

if ($uri == "/admin/reservations") {
    if (isset($_POST["action"])) {
        if ($_POST["action"] == "addReservation") {
            // Crée une réservation depuis l'interface admin.
            insertReservationAdmin($pdo);
        } elseif ($_POST["action"] == "updateReservation") {
            // Met à jour la réservation sélectionnée.
            updateReservationAdmin($pdo, $_POST["id_reservation"]);
        } elseif ($_POST["action"] == "deleteReservation") {
            // Supprime une réservation unique.
            deleteReservation($pdo, $_POST["id_reservation"]);
        }

        header("location:/admin/reservations");
        exit;
    }

    // Les listes des salles et utilisateurs alimentent les selects du formulaire.
    $salles = selectAllSalle($pdo);
    $users = selectAllUsers($pdo);
    $reservations = selectAllReservations($pdo);
    $template = "Views/admin/pageAdminReservations.php";
    $title = "Admin Reservations";
}

if (isset($template)) {
    // Rend la vue choisie dans le layout commun de l'application.
    require_once("Views/base.php");
}
