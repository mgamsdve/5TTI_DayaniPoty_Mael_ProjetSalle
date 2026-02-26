<div class="auth-card">
    <h1>Connexion</h1>
    <?php if ($message != null) : ?>
        <p class="form-error"><?= $message ?></p>
    <?php endif ?>
    <form action="" method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="votre@email.com">
        </div>
        <div class="form-group">
            <label for="mdp">Mot de passe</label>
            <input type="password" name="mdp" id="mdp" placeholder="••••••••">
        </div>
        <input type="submit" value="Se connecter" id="envoyer" name="envoyer">
    </form>
</div>