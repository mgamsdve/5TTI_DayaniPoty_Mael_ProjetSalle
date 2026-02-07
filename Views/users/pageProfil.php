<h1 class="section-title">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <circle cx="12" cy="7" r="4" />
        <path d="M5.5 21a6.5 6.5 0 0 1 13 0" />
    </svg>
    Mon profil
</h1>

<?php if (!empty($erreur)) : ?>
    <div class="form-error"><?= $erreur ?></div>
<?php endif; ?>

<form method="POST" class="form-card">

    <div class="input-group">
        <input type="text" name="nom"
            value="<?= htmlspecialchars($_SESSION["user"]->uti_nom) ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <circle cx="12" cy="7" r="4" />
            <path d="M5.5 21a6.5 6.5 0 0 1 13 0" />
        </svg>
    </div>

    <div class="input-group">
        <input type="text" name="prenom"
            value="<?= htmlspecialchars($_SESSION["user"]->uti_prenom) ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <circle cx="12" cy="7" r="4" />
            <path d="M5.5 21a6.5 6.5 0 0 1 13 0" />
        </svg>
    </div>

    <div class="input-group">
        <input type="email" name="email"
            value="<?= htmlspecialchars($_SESSION["user"]->uti_email) ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <rect x="3" y="3" width="18" height="18" rx="2" />
            <path d="M3 7l9 6 9-6" />
        </svg>
    </div>

    <input type="submit" value="Mettre à jour" name="envoyer" class="btn-full">
</form>

<div class="danger-zone">
    <a href="/deleteProfil" class="delete-link">
        Supprimer mon compte
    </a>
</div>