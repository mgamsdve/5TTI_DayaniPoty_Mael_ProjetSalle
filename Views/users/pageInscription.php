<h1>Inscription</h1>

<?php if (!empty($erreur)) : ?>
    <p class="form-error"><?= $erreur ?></p>
<?php endif; ?>

<form action="" method="POST">

    <label for="nom">Nom</label><br>
    <input type="text" name="nom" id="nom"><br>

    <label for="prenom">Prénom</label><br>
    <input type="text" name="prenom" id="prenom"><br>

    <label for="email">Email</label><br>
    <input type="email" name="email" id="email"><br>

    <label for="mdp">Mot de passe</label><br>
    <input type="password" name="mdp" id="mdp"><br><br>

    <input type="submit" value="Envoyer" name="envoyer">
</form>