<h1>Utilisateurs</h1>

<?php foreach ($users as $user) : ?>
    <p><strong>ID :</strong> <?= $user->id_utilisateur ?></p>
    <p><strong>Nom :</strong> <?= $user->uti_nom ?></p>
    <p><strong>Prénom :</strong> <?= $user->uti_prenom ?></p>
    <p><strong>Email :</strong> <?= $user->uti_email ?></p>
    <p><strong>Rôle :</strong> <?= $user->uti_role ?></p>
    <hr>
<?php endforeach ?>