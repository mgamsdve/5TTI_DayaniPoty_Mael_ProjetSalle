<?php
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$segments = explode("/", trim($uri, "/"));

require_once("Models/userModel.php");
require_once("Models/salleModel.php");
require_once("Models/equipementModel.php");
require_once("Models/reservationModel.php");
require_once("Models/contenanceModel.php");
require_once("Models/categorieModel.php");

if (strpos($uri, "/admin") === 0) {
    if (!isset($_SESSION["user"])) {
        header("location:/connexion");
        exit;
    }

    if ($_SESSION["user"]->uti_role != "admin") {
        header("location:/");
        exit;
    }
}

if ($uri == "/admin") {
    $template = "Views/admin/pageAdmin.php";
    $title = "Administration";
}

if ($uri == "/admin/users") {
    // Actions GET demandees pour valider les criteres d'evaluation admin.
    if (isset($_GET["action"])) {
        if ($_GET["action"] == "updateUserGet" && !empty($_GET["id_utilisateur"])) {
            if (
                !empty($_GET["nom"]) &&
                !empty($_GET["prenom"]) &&
                !empty($_GET["email"]) &&
                !empty($_GET["role"])
            ) {
                updateUserAdminByGet($pdo);
                if ($_SESSION["user"]->id_utilisateur == (int) $_GET["id_utilisateur"]) {
                    updateSession($pdo);
                }
            }

            header("location:/admin/users");
            exit;
        }

        if ($_GET["action"] == "deleteUserGet" && !empty($_GET["id_utilisateur"])) {
            $idUser = (int) $_GET["id_utilisateur"];

            // Evite de supprimer le compte admin connecte depuis l'admin.
            if ($idUser > 0 && $idUser != (int) $_SESSION["user"]->id_utilisateur) {
                deleteUserById($pdo);
            }

            header("location:/admin/users");
            exit;
        }
    }

    if (isset($_POST["action"])) {
        if ($_POST["action"] == "addUser") {
            insertUserAdmin($pdo);
        } elseif ($_POST["action"] == "deleteUsersMulti" && !empty($_POST["user_ids"])) {
            deleteUsersByIds($pdo);
        }

        header("location:/admin/users");
        exit;
    }

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
    $idUser = (int) $segments[3];
    $userDetails = selectUserById($pdo, $idUser);
    $userReservations = [];

    if ($userDetails) {
        $userReservations = selectReservationsByUserId($pdo, $userDetails->id_utilisateur);
    }

    $template = "Views/admin/pageAdminUserDetails.php";
    $title = "Detail Utilisateur";
}

if ($uri == "/admin/categories") {
    if (isset($_POST["action"])) {
        if ($_POST["action"] == "addCategory") {
            insertCategory($pdo);
        } elseif ($_POST["action"] == "updateCategory") {
            updateCategory($pdo, $_POST["id_categorie"]);
        } elseif ($_POST["action"] == "deleteCategory") {
            deleteCategory($pdo, $_POST["id_categorie"]);
        }

        header("location:/admin/categories");
        exit;
    }

    $categories = selectAllCategories($pdo);
    $template = "Views/admin/pageAdminCategories.php";
    $title = "Admin Categories";
}

if ($uri == "/admin/salles") {
    if (isset($_POST["action"])) {
        if ($_POST["action"] == "addSalle") {
            insertSalle($pdo);
        } elseif ($_POST["action"] == "deleteSallesMulti" && !empty($_POST["salle_ids"])) {
            deleteSallesByIds($pdo);
        } elseif ($_POST["action"] == "updateSalle") {
            updateSalle($pdo, $_POST["id_salle"]);
        } elseif ($_POST["action"] == "deleteSalle") {
            deleteSalle($pdo, $_POST["id_salle"]);
        }

        header("location:/admin/salles");
        exit;
    }

    $categories = selectAllCategories($pdo);
    $salles = selectAllSalle($pdo);
    $template = "Views/admin/pageAdminSalles.php";
    $title = "Admin Salles";
}

if ($uri == "/admin/equipements") {
    if (isset($_POST["action"])) {
        if ($_POST["action"] == "addEquipement") {
            insertEquipement($pdo);
        } elseif ($_POST["action"] == "updateEquipement") {
            updateEquipement($pdo, $_POST["id_equipement"]);
        } elseif ($_POST["action"] == "deleteEquipement") {
            deleteEquipement($pdo, $_POST["id_equipement"]);
        }

        header("location:/admin/equipements");
        exit;
    }

    $equipements = selectAllEquipements($pdo);
    $template = "Views/admin/pageAdminEquipements.php";
    $title = "Admin Equipements";
}

if ($uri == "/admin/contenances") {
    if (isset($_POST["action"])) {
        if ($_POST["action"] == "addContenance") {
            insertContenance($pdo);
        } elseif ($_POST["action"] == "updateContenance") {
            updateContenance($pdo, $_POST["id_contenance"]);
        } elseif ($_POST["action"] == "deleteContenance") {
            deleteContenance($pdo, $_POST["id_contenance"]);
        }

        header("location:/admin/contenances");
        exit;
    }

    $salles = selectAllSalle($pdo);
    $equipements = selectAllEquipements($pdo);
    $contenances = selectAllContenances($pdo);
    $template = "Views/admin/pageAdminContenances.php";
    $title = "Admin Contenances";
}

if ($uri == "/admin/reservations") {
    if (isset($_POST["action"])) {
        if ($_POST["action"] == "addReservation") {
            insertReservationAdmin($pdo);
        } elseif ($_POST["action"] == "updateReservation") {
            updateReservationAdmin($pdo, $_POST["id_reservation"]);
        } elseif ($_POST["action"] == "deleteReservation") {
            deleteReservation($pdo, $_POST["id_reservation"]);
        }

        header("location:/admin/reservations");
        exit;
    }

    $salles = selectAllSalle($pdo);
    $users = selectAllUsers($pdo);
    $reservations = selectAllReservations($pdo);
    $template = "Views/admin/pageAdminReservations.php";
    $title = "Admin Reservations";
}

if (isset($template)) {
    require_once("Views/base.php");
}
