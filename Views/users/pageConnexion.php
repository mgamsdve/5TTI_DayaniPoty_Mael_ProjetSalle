<div class="auth-card">
    <!-- Carte dédiée à l'authentification. -->
    <h1>Connexion</h1>
    <!-- Message affiché lorsqu'un identifiant est incorrect. -->
    <?php if ($message != null) : ?>
        <p class="form-error"><?= $message ?></p>
    <?php endif ?>
    <!-- Formulaire de connexion envoyé au même contrôleur. -->
    <form action="" method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="votre@email.com" required>
        </div>
        <div class="form-group">
            <label for="mdp">Mot de passe</label>
            <input type="password" name="mdp" id="mdp" placeholder="••••••••" required>
        </div>
        <input type="submit" value="Se connecter" id="envoyer" name="envoyer">
    </form>
    <!-- Lien de secours pour les visiteurs qui n'ont pas encore de compte. -->
    <p class="auth-footer">
        Pas encore de compte ? <a href="/inscription">S'inscrire</a>
    </p>
</div>
