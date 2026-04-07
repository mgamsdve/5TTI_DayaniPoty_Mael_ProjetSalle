<div class="auth-card auth-card--wide">
    <div class="profile-header">
        <div class="avatar-circle avatar-circle--lg">
            <?= strtoupper(substr($_SESSION["user"]->uti_prenom, 0, 1) . substr($_SESSION["user"]->uti_nom, 0, 1)) ?>
        </div>
        <h1 class="profile-title">Votre Profil</h1>
    </div>

    <form action="" method="POST">
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" value="<?= $_SESSION["user"]->uti_nom ?>">
        </div>

        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" id="prenom" value="<?= $_SESSION["user"]->uti_prenom ?>">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= $_SESSION["user"]->uti_email ?>">
        </div>

        <input type="submit" value="Mettre à jour" name="envoyer" class="profile-submit">
    </form>

    <div id="profile-links" class="profile-actions">
        <a href="" class="btn-link">Réinitialiser le mot de passe</a>
        <a href="/deconnexion" class="btn-link">Se déconnecter</a>
        <a href="deleteProfil" class="btn-danger">Supprimer le compte</a>
    </div>
</div>
