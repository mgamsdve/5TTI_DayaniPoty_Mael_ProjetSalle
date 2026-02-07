<h1 class="section-title">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path d="M15 3h4v18h-4" />
        <path d="M10 17l5-5-5-5" />
        <path d="M15 12H3" />
    </svg>
    Connexion
</h1>

<?php if (!empty($message)) : ?>
    <div class="form-error"><?= $message ?></div>
<?php endif; ?>

<form method="POST" class="form-card">

    <div class="input-group">
        <input type="email" name="email" placeholder="Adresse email">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <rect x="3" y="3" width="18" height="18" rx="2" />
            <path d="M3 7l9 6 9-6" />
        </svg>
    </div>

    <div class="input-group">
        <input type="password" name="mdp" placeholder="Mot de passe">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <rect x="3" y="11" width="18" height="11" rx="2" />
            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
        </svg>
    </div>

    <input type="submit" value="Connexion" name="envoyer" class="btn-full">
</form>