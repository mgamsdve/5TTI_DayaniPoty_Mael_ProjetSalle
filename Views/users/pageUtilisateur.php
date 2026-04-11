<!-- Page publique qui présente la liste des utilisateurs enregistrés. -->
<h1>Utilisateurs</h1>

<!-- Conteneur en grille pour afficher les cartes utilisateur. -->
<div class="Salle-container">
    <?php foreach ($users as $user) : ?>
        <!-- Chaque carte résume un compte avec identité, email et rôle. -->
        <div class="salle">
            <div class="user-summary">
                <!-- Avatar construit à partir des initiales pour donner un repère visuel rapide. -->
                <div class="avatar-circle avatar-circle--sm">
                    <?= strtoupper(substr($user->uti_prenom, 0, 1) . substr($user->uti_nom, 0, 1)) ?>
                </div>
                <h3><?= htmlspecialchars($user->uti_nom) ?> <?= htmlspecialchars($user->uti_prenom) ?></h3>
            </div>
            <!-- Les informations affichées ici proviennent directement de la table utilisateur. -->
            <p><strong>Email :</strong> <?= htmlspecialchars($user->uti_email) ?></p>
            <p>
                <strong>Rôle :</strong>
                <span class="role <?= strtolower($user->uti_role) ?>"><?= htmlspecialchars($user->uti_role) ?></span>
            </p>
            <!-- L'id permet d'identifier sans ambiguïté la ligne en base. -->
            <p class="user-id">ID : #<?= $user->id_utilisateur ?></p>
        </div>
    <?php endforeach ?>
</div>
