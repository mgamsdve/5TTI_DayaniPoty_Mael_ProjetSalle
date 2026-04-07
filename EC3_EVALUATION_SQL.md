# EC3 – ÉVALUATION SQL : REQUÊTES DU PROJET

## 1. Insérer un nouvel utilisateur
```php
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
```
Ce code insère un nouvel enregistrement dans la table `Utilisateur` à partir du formulaire d’inscription.
Le mot de passe est haché avant l’insertion et le rôle est forcé à `utilisateur` pour les comptes créés par les visiteurs.

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
Cette requête charge un utilisateur précis depuis `Utilisateur` à partir de son identifiant.
Comme la requête fait un `SELECT *`, le champ `uti_role` est récupéré en même temps que les autres données du compte.

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
Cette suppression est utilisée depuis l’interface admin pour retirer un utilisateur ciblé par son `id_utilisateur`.
Le code vérifie d’abord que l’identifiant est valide avant d’exécuter la requête `DELETE`.

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
La liste des cases cochées du tableau admin est envoyée dans un seul formulaire caché via `user_ids[]`.
La même requête `DELETE` est rejouée pour chaque identifiant sélectionné afin de supprimer plusieurs comptes d’un coup.

## 5. Mises à jour d'un utilisateur
```php
function updateUser($pdo)
{
    try {
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
```
Cette mise à jour sert au formulaire du profil pour modifier les informations du compte connecté.
Elle met à jour le nom, le prénom et l’email de l’utilisateur stocké en session.

## 6. Insérer dans la table de liaison pour un utilisateur avec son id et les données des FK
```php
function insertReservation($pdo)
{
    try {
        $userId = $_SESSION["user"]->id_utilisateur;
        $query = 'INSERT INTO Reservation (id_salle, id_utilisateur, res_dateDebut, res_dateFin)
            VALUES (:idSalle, :idUtilisateur, :dateDebut, :dateFin)';
        $insertReservation = $pdo->prepare($query); //preparer la query
        $insertReservation->execute([
            "idSalle" => $_POST["id_salle"],
            "idUtilisateur" => $userId,
            "dateDebut" => $_POST["dateDebut"],
            "dateFin" => $_POST["dateFin"]
        ]); //executer la query
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}
```
Cette insertion relie une salle à l’utilisateur connecté dans la table `Reservation`.
L’id utilisateur vient de la session, tandis que l’id de salle et les dates viennent du formulaire de création de réservation.

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
Le formulaire de création permet de sélectionner plusieurs salles avec `id_salles[]`, puis la boucle crée une ligne `Reservation` par salle.
Chaque insertion garde le même utilisateur connecté et les mêmes dates, ce qui produit plusieurs réservations en une seule soumission.

## 8. Modifier la table de liaison avec 2 selects
```php
function updateContenance($pdo, $idContenance)
{
    try {
        $query = 'UPDATE Contenance
            SET id_equipement = :idEquipement, id_salle = :idSalle, cont_quantite = :quantite
            WHERE id_contenance = :idContenance';
        $updateContenance = $pdo->prepare($query); //preparer la query
        $updateContenance->execute([
            "idEquipement" => $_POST["id_equipement"],
            "idSalle" => $_POST["id_salle"],
            "quantite" => $_POST["quantite"],
            "idContenance" => $idContenance
        ]); //executer la query
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}
```
Cette mise à jour modifie une ligne de liaison entre salle et équipement dans `Contenance`.
Les deux `select` de l’interface admin renvoient un nouvel `id_salle` et un nouvel `id_equipement`, puis la quantité est recalculée avec la même soumission.

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
        $selectReservations = $pdo->prepare($query); //preparer la query
        $selectReservations->execute([
            "idUtilisateur" => $idUtilisateur
        ]); //executer la query
        $reservations = $selectReservations->fetchAll(); //recuperer les donnees
        return $reservations;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}
```
Cette requête récupère toutes les réservations d’un utilisateur précis pour la fiche admin du compte.
Elle ajoute les données de la salle associée afin d’afficher le nom, le numéro et l’image sans requête supplémentaire dans la vue.

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
La page admin des salles envoie les identifiants cochés dans un formulaire caché, ce qui permet de supprimer plusieurs salles d’un seul coup.
Les suppressions sont exécutées une à une, et les tables liées sont nettoyées automatiquement grâce aux clés étrangères en `ON DELETE CASCADE`.

---
TOTAL : 10/10

---