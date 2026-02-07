<h1 class="section-title">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
        <circle cx="8.5" cy="7" r="4" />
    </svg>
    Inscription
</h1>

<?php if (!empty($erreur)) : ?>
    <div class="form-error"><?= $erreur ?></div>
<?php endif; ?>

<form class="form-card" method="POST">

    <div class="input-group">
        <input type="text" name="nom" placeholder="Nom">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8" />
            <circle cx="12" cy="7" r="4" />
        </svg>
    </div>

    <div class="input-group">
        <input type="text" name="prenom" placeholder="Prénom">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8" />
            <circle cx="12" cy="7" r="4" />
        </svg>
    </div>

    <div class="input-group">
        <input type="email" name="email" placeholder="Email">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path d="M4 4h16v16H4z" />
            <path d="M4 4l8 8 8-8" />
        </svg>
    </div>

    <div class="input-group">
        <input type="password" name="mdp" placeholder="Mot de passe">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <rect x="3" y="11" width="18" height="11" rx="2" />
            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
        </svg>
    </div>

    <input type="submit" value="Créer le compte" name="envoyer" class="btn-full">
</form>

<div class="link-soft">
    Déjà un compte ? <a href="/connexion">Se connecter</a>
</div>