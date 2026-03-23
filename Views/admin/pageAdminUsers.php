<div class="admin-layout">
    <?php require_once("Views/Components/admin-sidebar.php"); ?>
    <div class="admin-content">
        <h1>Utilisateurs</h1>
        <a href="/admin" class="admin-back">
            <i data-lucide="arrow-left" style="width:14px;height:14px;"></i>
            Retour à l'administration
        </a>

        <section class="admin-section">
            <form method="POST" class="admin-form">
                <input type="hidden" name="action" value="addUser">

                <label for="user_nom">Nom</label>
                <input type="text" name="nom" id="user_nom" required>

                <label for="user_prenom">Prénom</label>
                <input type="text" name="prenom" id="user_prenom" required>

                <label for="user_email">Email</label>
                <input type="email" name="email" id="user_email" required>

                <label for="user_mdp">Mot de passe</label>
                <input type="password" name="mdp" id="user_mdp" required>

                <label for="user_role">Rôle</label>
                <select name="role" id="user_role">
                    <option value="utilisateur">utilisateur</option>
                    <option value="admin">admin</option>
                </select>

                <input type="submit" value="Ajouter un utilisateur">
            </form>

            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td><?= $user->id_utilisateur ?></td>
                                <td><input type="text" name="nom" value="<?= $user->uti_nom ?>" form="user-form-<?= $user->id_utilisateur ?>" required></td>
                                <td><input type="text" name="prenom" value="<?= $user->uti_prenom ?>" form="user-form-<?= $user->id_utilisateur ?>" required></td>
                                <td><input type="email" name="email" value="<?= $user->uti_email ?>" form="user-form-<?= $user->id_utilisateur ?>" required></td>
                                <td>
                                    <select name="role" form="user-form-<?= $user->id_utilisateur ?>">
                                        <option value="utilisateur" <?= $user->uti_role == "utilisateur" ? "selected" : "" ?>>utilisateur</option>
                                        <option value="admin" <?= $user->uti_role == "admin" ? "selected" : "" ?>>admin</option>
                                    </select>
                                </td>
                                <td>
                                    <form method="POST" id="user-form-<?= $user->id_utilisateur ?>" class="admin-inline-form">
                                        <input type="hidden" name="action" value="updateUser">
                                        <input type="hidden" name="id_utilisateur" value="<?= $user->id_utilisateur ?>">
                                        <button type="submit">Modifier</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
