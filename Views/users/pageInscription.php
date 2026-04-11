<div class="auth-card">
    <!-- Carte dédiée à la création d'un nouveau compte. -->
    <h1>Inscription</h1>

    <!-- Le formulaire envoie les données au contrôleur utilisateur. -->
    <form action="" method="POST">
        <div class="form-group">
            <!-- Chaque champ est regroupé avec son label et son message d'erreur. -->
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" value="<?= $_POST["nom"] ?? "" ?>" placeholder="Nom" required>
            <?php if (isset($messageError["nom"])): ?>
                <small class="form-error"><?= $messageError["nom"] ?></small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" id="prenom" value="<?= $_POST["prenom"] ?? "" ?>" placeholder="Prénom" required>
            <?php if (isset($messageError["prenom"])): ?>
                <small class="form-error"><?= $messageError["prenom"] ?></small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= $_POST["email"] ?? "" ?>" placeholder="votre.email@example.com" required>
            <?php if (isset($messageError["email"])): ?>
                <small class="form-error"><?= $messageError["email"] ?></small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="mdp">Mot de passe</label>
            <input type="password" name="mdp" id="mdp" placeholder="Votre mot de passe" required>
            <?php if (isset($messageError["mdp"])): ?>
                <small class="form-error"><?= $messageError["mdp"] ?></small>
            <?php endif; ?>
        </div>

        <input type="submit" value="S'inscrire" name="envoyer">
    </form>
    <!-- Renvoie vers la page de connexion si l'utilisateur possède déjà un compte. -->
    <p class="auth-footer">
        Déjà un compte ? <a href="/connexion">Se connecter</a>
    </p>
</div>
<!-- Validation JavaScript spécifique à l'inscription. -->
<script src="/Assets/JS/form-inscription.js"></script>
