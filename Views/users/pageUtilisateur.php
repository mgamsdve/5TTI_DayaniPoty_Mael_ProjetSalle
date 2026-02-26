<h1>Liste des Utilisateurs</h1>

<div class="Salle-container ">
    <?php foreach ($users as $user) : ?>
        <div class="salle">
            <h3><?= $user->uti_nom ?> <?= $user->uti_prenom ?></h3>
            <p><strong>Email :</strong> <?= $user->uti_email ?></p>
            <p><strong>Rôle :</strong> <span class="role <?= strtolower($user->uti_role) ?>"><?= $user->uti_role ?></span></p>
            <p><strong>ID :</strong> #<?= $user->id_utilisateur ?></p>
        </div>
    <?php endforeach ?>
</div>