<div class="auth-card">
    <h1>Votre Profil</h1>

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

        <div id="profile-links">
            <a href="" class="btn-link">Réinitialiser le mot de passe</a>
            <a href="deleteProfil" class="btn-link">Supprimer le compte</a>
            <a href="/deconnexion" class="btn-link">Se déconnecter</a>
        </div>
        <input type="submit" value="Mettre à jour" name="envoyer">
    </form>
</div>