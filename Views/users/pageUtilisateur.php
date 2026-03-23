<h1>Utilisateurs</h1>

<div class="Salle-container">
    <?php foreach ($users as $user) : ?>
        <div class="salle">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:8px;">
                <div style="width:40px; height:40px; border-radius:50%; background:var(--primary-light); color:var(--primary); font-size:0.85rem; font-weight:700; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <?= strtoupper(substr($user->uti_prenom, 0, 1) . substr($user->uti_nom, 0, 1)) ?>
                </div>
                <h3><?= htmlspecialchars($user->uti_nom) ?> <?= htmlspecialchars($user->uti_prenom) ?></h3>
            </div>
            <p><strong>Email :</strong> <?= htmlspecialchars($user->uti_email) ?></p>
            <p>
                <strong>Rôle :</strong>
                <span class="role <?= strtolower($user->uti_role) ?>"><?= htmlspecialchars($user->uti_role) ?></span>
            </p>
            <p style="color:var(--text-muted); font-size:0.8rem;">ID : #<?= $user->id_utilisateur ?></p>
        </div>
    <?php endforeach ?>
</div>
