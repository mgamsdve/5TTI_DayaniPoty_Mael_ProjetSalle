<div class="auth-card">
    <h1>Inscription</h1>

    <form action="" method="POST">
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" value="<?= $_POST["nom"] ?? "" ?>" placeholder="Nom">
            <?php if (isset($messageError["nom"])) : ?>
                <small class="form-error"><?= $messageError["nom"] ?></small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" id="prenom" value="<?= $_POST["prenom"] ?? "" ?>" placeholder="Prenom">
            <?php if (isset($messageError["prenom"])) : ?>
                <small class="form-error"><?= $messageError["prenom"] ?></small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= $_POST["email"] ?? "" ?>" placeholder="votre.email@example.com">
            <?php if (isset($messageError["email"])) : ?>
                <small class="form-error"><?= $messageError["email"] ?></small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="mdp">Mot de passe</label>
            <input type="password" name="mdp" id="mdp" placeholder="votre mot de passe">
            <?php if (isset($messageError["mdp"])) : ?>
                <small class="form-error"><?= $messageError["mdp"] ?></small>
            <?php endif; ?>
        </div>

        <input type="submit" value="S'inscrire" name="envoyer">
    </form>
</div>