<div class="auth-card" style="max-width: 520px;">
    <div style="display:flex; flex-direction:column; align-items:center; margin-bottom: 28px; gap: 12px;">
        <div style="width:64px; height:64px; border-radius:50%; background:var(--primary-light); color:var(--primary); font-size:1.5rem; font-weight:700; display:flex; align-items:center; justify-content:center;">
            <?= strtoupper(substr($_SESSION["user"]->uti_prenom, 0, 1) . substr($_SESSION["user"]->uti_nom, 0, 1)) ?>
        </div>
        <h1 style="margin-bottom:0; font-size:1.4rem;">Votre Profil</h1>
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

        <input type="submit" value="Mettre à jour" name="envoyer" style="width:100%; justify-content:center; margin-bottom: 16px;">
    </form>

    <div id="profile-links">
        <a href="" class="btn-link">Réinitialiser le mot de passe</a>
        <a href="/deconnexion" class="btn-link">Se déconnecter</a>
        <a href="deleteProfil" class="btn-danger" style="padding: 8px 16px; font-size:0.85rem; border-radius: var(--radius-sm);">Supprimer le compte</a>
    </div>
</div>
