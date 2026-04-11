<!-- Layout d'administration pour la gestion des utilisateurs. -->
<div class="admin-layout">
    <?php require_once("Views/Components/admin-sidebar.php"); ?>
    <!-- Zone principale dédiée aux formulaires et au tableau. -->
    <div class="admin-content">
        <h1>Utilisateurs</h1>
        <a href="/admin" class="admin-back">
            <i data-lucide="arrow-left" class="icon-14"></i>
            Retour à l'administration
        </a>

        <!-- Section qui regroupe le formulaire d'ajout et le tableau de gestion. -->
        <section class="admin-section">
            <!-- Formulaire de création d'un utilisateur. -->
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
                <select name="role" id="user_role" required>
                    <option value="utilisateur">utilisateur</option>
                    <option value="admin">admin</option>
                </select>

                <input type="submit" value="Ajouter un utilisateur">
            </form>

            <!-- Bloc visuel qui explique la suppression multiple. -->
            <div class="admin-form admin-bulk-card">
                <label for="admin-users-bulk-select" class="mt-0">Suppression multiple (multi select)</label>
                <p>Cochez des utilisateurs dans le tableau puis lancez la suppression de groupe.</p>
                <input type="submit" id="admin-users-bulk-select" value="Supprimer les utilisateurs selectionnes" class="btn-danger" form="bulk-delete-users-form">
            </div>

            <!-- Recherche textuelle pour filtrer les lignes du tableau. -->
            <div class="admin-search" role="search">
                <label for="admin-users-search-input">Rechercher un utilisateur</label>
                <input
                    type="text"
                    id="admin-users-search-input"
                    placeholder="Nom, prénom, email, rôle ou ID..."
                    autocomplete="off"
                >
            </div>

            <!-- Tableau de gestion des comptes avec modification et suppression. -->
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Selection</th>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) : ?>
                            <!-- Chaque ligne représente un utilisateur avec ses actions. -->
                            <tr data-search="<?= htmlspecialchars(strtolower($user->id_utilisateur . ' ' . $user->uti_nom . ' ' . $user->uti_prenom . ' ' . $user->uti_email . ' ' . $user->uti_role), ENT_QUOTES, 'UTF-8') ?>">
                                <td>
                                    <input
                                        type="checkbox"
                                        name="user_ids[]"
                                        value="<?= $user->id_utilisateur ?>"
                                        form="bulk-delete-users-form"
                                        aria-label="Selectionner l'utilisateur <?= $user->id_utilisateur ?>"
                                    >
                                </td>
                                <td><?= $user->id_utilisateur ?></td>
                                <td>
                                    <a href="/admin/users/details/<?= $user->id_utilisateur ?>" class="admin-user-link">
                                        <?= htmlspecialchars($user->uti_nom) ?>
                                    </a>
                                </td>
                                <td><input type="text" name="prenom" value="<?= $user->uti_prenom ?>" form="user-form-<?= $user->id_utilisateur ?>" required></td>
                                <td><input type="email" name="email" value="<?= $user->uti_email ?>" form="user-form-<?= $user->id_utilisateur ?>" required></td>
                                <td>
                                    <select name="role" form="user-form-<?= $user->id_utilisateur ?>" required>
                                        <option value="utilisateur" <?= $user->uti_role == "utilisateur" ? "selected" : "" ?>>utilisateur</option>
                                        <option value="admin" <?= $user->uti_role == "admin" ? "selected" : "" ?>>admin</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="admin-inline-form">
                                        <!-- Formulaire GET utilisé pour mettre à jour la ligne. -->
                                        <form method="GET" action="/admin/users" id="user-form-<?= $user->id_utilisateur ?>" class="admin-inline-form">
                                            <input type="hidden" name="action" value="updateUserGet">
                                            <input type="hidden" name="id_utilisateur" value="<?= $user->id_utilisateur ?>">
                                            <input type="hidden" name="nom" value="<?= htmlspecialchars($user->uti_nom, ENT_QUOTES, 'UTF-8') ?>">
                                            <button type="submit">Modifier</button>
                                        </form>

                                        <!-- Formulaire GET utilisé pour supprimer un compte. -->
                                        <form method="GET" action="/admin/users" class="admin-inline-form" onsubmit="return confirm('Supprimer cet utilisateur ?');">
                                            <input type="hidden" name="action" value="deleteUserGet">
                                            <input type="hidden" name="id_utilisateur" value="<?= $user->id_utilisateur ?>">
                                            <button type="submit" class="btn-delete btn-delete--compact">Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>

            <!-- Formulaire caché utilisé par la suppression de groupe. -->
            <form method="POST" id="bulk-delete-users-form" hidden>
                <input type="hidden" name="action" value="deleteUsersMulti">
            </form>

            <!-- Message affiché si le filtre ne trouve aucun utilisateur. -->
            <p id="admin-users-no-results" class="admin-no-results" hidden>Aucun utilisateur ne correspond à votre recherche.</p>
        </section>
    </div>
</div>

<!-- Active le filtrage des lignes du tableau. -->
<script>
    initSearchFilter({
        inputSelector: "#admin-users-search-input",
        itemSelector: ".admin-table tbody tr",
        emptySelector: "#admin-users-no-results",
        visibleDisplay: "table-row"
    });
</script>
