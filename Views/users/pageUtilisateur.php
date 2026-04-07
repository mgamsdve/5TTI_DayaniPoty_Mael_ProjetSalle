<h1>Utilisateurs</h1>

<div class="Salle-container">
    <?php foreach ($users as $user) : ?>
        <div class="salle">
            <div class="user-summary">
                <div class="avatar-circle avatar-circle--sm">
                    <?= strtoupper(substr($user->uti_prenom, 0, 1) . substr($user->uti_nom, 0, 1)) ?>
                </div>
                <h3><?= htmlspecialchars($user->uti_nom) ?> <?= htmlspecialchars($user->uti_prenom) ?></h3>
            </div>
            <p><strong>Email :</strong> <?= htmlspecialchars($user->uti_email) ?></p>
            <p>
                <strong>Rôle :</strong>
                <span class="role <?= strtolower($user->uti_role) ?>"><?= htmlspecialchars($user->uti_role) ?></span>
            </p>
            <p class="user-id">ID : #<?= $user->id_utilisateur ?></p>
        </div>
    <?php endforeach ?>
</div>
