<h1>Inscription</h1>

<form action="" method="POST">
    <label for="nom">Nom</label><br>
    <input type="text" name="nom" id="nom" value="<?= $_POST["nom"] ?? "" ?>"><br>
    <?php if (isset($messageError["nom"])) : ?>
        <small><?= $messageError["nom"] ?></small><br>
    <?php endif; ?>
    <br>

    <label for="prenom">Prénom</label><br>
    <input type="text" name="prenom" id="prenom" value="<?= $_POST["prenom"] ?? "" ?>"><br>
    <?php if (isset($messageError["prenom"])) : ?>
        <small><?= $messageError["prenom"] ?></small><br>
    <?php endif; ?>
    <br>

    <label for="email">Email</label><br>
    <input type="email" name="email" id="email" value="<?= $_POST["email"] ?? "" ?>"><br>
    <?php if (isset($messageError["email"])) : ?>
        <small><?= $messageError["email"] ?></small><br>
    <?php endif; ?>
    <br>

    <label for="mdp">Mot de passe</label><br>
    <input type="password" name="mdp" id="mdp"><br>
    <?php if (isset($messageError["mdp"])) : ?>
        <small><?= $messageError["mdp"] ?></small><br>
    <?php endif; ?>
    <br>

    <input type="submit" value="Envoyer" name="envoyer">

</form>