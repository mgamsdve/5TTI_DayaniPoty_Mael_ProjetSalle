
# EC3 – ÉVALUATION SQL : REQUÊTES DU PROJET

Ce document présente les dix requêtes SQL réalisées dans le cadre du projet. Chaque requête correspond à un besoin fonctionnel précis de l'application et est implémentée en PHP via PDO avec des requêtes préparées pour sécuriser les échanges avec la base de données.

---

## 1. Insérer un nouvel utilisateur

```php
function insertUser($pdo)
{
    try {
        $query = 'INSERT INTO Utilisateur (uti_nom, uti_prenom, uti_email, uti_mdp, uti_role)
            VALUES (:nom, :prenom, :email, :mdp, :role)';
        $insertUser = $pdo->prepare($query);
        $insertUser->execute([
            "nom"    => $_POST["nom"],
            "prenom" => $_POST["prenom"],
            "email"  => $_POST["email"],
            "mdp"    => password_hash($_POST["mdp"], PASSWORD_DEFAULT),
            "role"   => "utilisateur"
        ]);
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}
```

Ce code insère un nouvel enregistrement dans la table `Utilisateur` à partir des données du formulaire d'inscription. Le mot de passe est haché avec `password_hash()` avant l'insertion pour ne jamais stocker le mot de passe en clair. Le rôle est volontairement forcé à la valeur `"utilisateur"` dans le code, et non récupéré depuis le formulaire, afin d'empêcher qu'un visiteur puisse s'attribuer un rôle administrateur.

---

## 2. Sélectionner 1 utilisateur avec son rôle

```php
function selectUserById($pdo, $idUser)
{
    try {
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
```

Cette requête charge un utilisateur précis depuis la table `Utilisateur` à partir de son identifiant. Le `SELECT *` récupère l'ensemble des colonnes du compte en une seule requête, ce qui inclut directement le champ `uti_role` sans avoir à le cibler séparément. Ce choix est justifié ici car toutes les données du compte sont utilisées dans la vue qui suit l'appel.

---

## 3. Supprimer 1 utilisateur

```php
function deleteUserById($pdo)
{
    try {
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
```

Cette suppression est utilisée depuis l'interface admin pour retirer un utilisateur ciblé par son `id_utilisateur` passé en paramètre GET. Avant d'exécuter la requête `DELETE`, le code vérifie que l'identifiant est un entier strictement positif, ce qui évite d'exécuter une suppression avec une valeur invalide ou manquante.

---

## 4. Supprimer plusieurs utilisateurs avec un seul formulaire

```php
function deleteUsersByIds($pdo)
{
    try {
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
```

La liste des cases cochées dans le tableau admin est envoyée dans un seul formulaire via le champ `user_ids[]`. La requête `DELETE` est préparée une seule fois avant la boucle, puis exécutée pour chaque identifiant sélectionné, ce qui est plus efficace que de préparer une nouvelle requête à chaque tour. Cela permet de supprimer plusieurs comptes en une seule soumission de formulaire.

---

## 5. Mises à jour d'un utilisateur

```php
function updateUser($pdo)
{
    try {
        $query = 'UPDATE utilisateur SET uti_nom = :nom, uti_prenom = :prenom, uti_email = :email
            WHERE id_utilisateur = :userId';
        $insertUser = $pdo->prepare($query);
        $insertUser->execute([
            "nom"    => $_POST["nom"],
            "prenom" => $_POST["prenom"],
            "email"  => $_POST["email"],
            "userId"   => $_SESSION["user"]->id_utilisateur
        ]);
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}
```

Cette mise à jour sert au formulaire de profil pour modifier les informations du compte connecté. L'identifiant utilisé dans la clause `WHERE` est récupéré depuis la session et non depuis le formulaire, ce qui empêche un utilisateur de modifier le compte d'une autre personne en falsifiant l'id dans la requête.

---

## 6. Insérer dans la table de liaison pour un utilisateur avec son id et les données des FK

```php
function insertReservation($pdo)
{
    try {
        $userId = $_SESSION["user"]->id_utilisateur;
        $query = 'INSERT INTO Reservation (id_salle, id_utilisateur, res_dateDebut, res_dateFin)
            VALUES (:idSalle, :idUtilisateur, :dateDebut, :dateFin)';
        $insertReservation = $pdo->prepare($query);
        $insertReservation->execute([
            "idSalle" => $_POST["id_salle"],
            "idUtilisateur" => $userId,
            "dateDebut" => $_POST["dateDebut"],
            "dateFin" => $_POST["dateFin"]
        ]);
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}
```

Cette insertion crée une ligne dans la table de liaison `Reservation` qui relie une salle à l'utilisateur connecté. L'`id_utilisateur` est récupéré depuis la session pour garantir que la réservation est bien associée au bon compte, tandis que l'`id_salle` et les dates proviennent du formulaire de création de réservation.

---

## 7. Insérer plusieurs lignes dans la table de liaison pour un utilisateur avec son id et les données des FK

```php
function insertReservationsMultiForUser($pdo)
{
    try {
        $idSalles = $_POST["id_salles"] ?? [];
        $idUtilisateur = (int) $_SESSION["user"]->id_utilisateur;
        $dateDebut = $_POST["dateDebut"] ?? "";
        $dateFin = $_POST["dateFin"] ?? "";

        if (empty($idSalles)) {
            return;
        }

        $query = 'INSERT INTO Reservation (id_salle, id_utilisateur, res_dateDebut, res_dateFin)
            VALUES (:idSalle, :idUtilisateur, :dateDebut, :dateFin)';
        $insertReservation = $pdo->prepare($query);

        foreach ($idSalles as $idSalle) {
            $insertReservation->execute([
                "idSalle" => (int) $idSalle,
                "idUtilisateur" => $idUtilisateur,
                "dateDebut" => $dateDebut,
                "dateFin" => $dateFin
            ]);
        }
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}
```

Le formulaire permet de sélectionner plusieurs salles via le champ `id_salles[]`. La requête `INSERT` est préparée une seule fois, puis la boucle crée une ligne dans `Reservation` pour chaque salle cochée. Chaque insertion conserve le même utilisateur connecté et les mêmes dates, ce qui produit plusieurs réservations distinctes en une seule soumission.

---

## 8. Modifier la table de liaison avec 2 selects

```php
function updateContenance($pdo, $idContenance)
{
    try {
        $query = 'UPDATE Contenance
            SET id_equipement = :idEquipement, id_salle = :idSalle, cont_quantite = :quantite
            WHERE id_contenance = :idContenance';
        $updateContenance = $pdo->prepare($query);
        $updateContenance->execute([
            "idEquipement" => $_POST["id_equipement"],
            "idSalle" => $_POST["id_salle"],
            "quantite" => $_POST["quantite"],
            "idContenance" => $idContenance
        ]);
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}
```

Le formulaire d'administration contient deux balises `<select>` : le premier affiche la liste des salles disponibles et envoie un `id_salle`, le second affiche la liste des équipements et envoie un `id_equipement`. Ces deux valeurs sont les clés étrangères de la table de liaison `Contenance`. La requête `UPDATE` les utilise pour remplacer la salle et l'équipement associés à une ligne existante, tout en mettant à jour la quantité dans la même soumission.

---

## 9. Sélectionner les lignes de la table de liaison avec la FK utilisateur et les données des autres FK

```php
function selectReservationsByUserId($pdo, $idUtilisateur)
{
    try {
        $query = 'SELECT Reservation.*, Salle.sal_nom, Salle.sal_image, Salle.sal_numero
            FROM Reservation
            INNER JOIN Salle ON Salle.id_salle = Reservation.id_salle
            WHERE Reservation.id_utilisateur = :idUtilisateur
            ORDER BY Reservation.res_dateDebut DESC';
        $selectReservations = $pdo->prepare($query);
        $selectReservations->execute([
            "idUtilisateur" => $idUtilisateur
        ]);
        $reservations = $selectReservations->fetchAll();
        return $reservations;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}
```

Cette requête récupère toutes les réservations d'un utilisateur précis en filtrant sur sa clé étrangère `id_utilisateur`. Un `INNER JOIN` est utilisé pour joindre la table `Salle` : ce type de jointure garantit qu'on ne récupère que les réservations qui ont une salle existante en base. Cela évite une seconde requête dans la vue pour afficher le nom, le numéro et l'image de chaque salle réservée.

---

## 10. Supprimer plusieurs lignes d'une autre table que utilisateur

```php
function deleteSallesByIds($pdo)
{
    try {
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
```

La page admin des salles envoie les identifiants cochés via le champ `salle_ids[]` dans un seul formulaire. Comme pour la suppression multiple d'utilisateurs, la requête est préparée une seule fois et exécutée en boucle pour chaque identifiant, ce qui permet de supprimer plusieurs salles en une seule soumission. Les enregistrements liés dans les autres tables sont nettoyés automatiquement grâce aux contraintes `ON DELETE CASCADE` définies sur les clés étrangères.

---