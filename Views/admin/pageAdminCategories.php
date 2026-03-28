<div class="admin-layout">
    <?php require_once("Views/Components/admin-sidebar.php"); ?>
    <div class="admin-content">
        <h1>Catégories</h1>
        <a href="/admin" class="admin-back">
            <i data-lucide="arrow-left" style="width:14px;height:14px;"></i>
            Retour à l'administration
        </a>

        <section class="admin-section">
            <form method="POST" class="admin-form">
                <input type="hidden" name="action" value="addCategory">

                <label for="cat_nom">Nom</label>
                <input type="text" name="nom" id="cat_nom" required>

                <input type="submit" value="Ajouter une catégorie">
            </form>

            <div class="admin-search" role="search">
                <label for="admin-categories-search-input">Rechercher une catégorie</label>
                <input
                    type="text"
                    id="admin-categories-search-input"
                    placeholder="Nom ou ID..."
                    autocomplete="off"
                >
            </div>

            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category) : ?>
                            <tr data-search="<?= htmlspecialchars(strtolower($category->id_categorie . ' ' . $category->cat_nom), ENT_QUOTES, 'UTF-8') ?>">
                                <td><?= $category->id_categorie ?></td>
                                <td><input type="text" name="nom" value="<?= $category->cat_nom ?>" form="category-form-<?= $category->id_categorie ?>" required></td>
                                <td>
                                    <form method="POST" id="category-form-<?= $category->id_categorie ?>" class="admin-inline-form">
                                        <input type="hidden" name="action" value="updateCategory">
                                        <input type="hidden" name="id_categorie" value="<?= $category->id_categorie ?>">
                                        <button type="submit">Modifier</button>
                                    </form>
                                </td>
                                <td>
                                    <form method="POST" class="admin-inline-form">
                                        <input type="hidden" name="action" value="deleteCategory">
                                        <input type="hidden" name="id_categorie" value="<?= $category->id_categorie ?>">
                                        <button type="submit" class="btn-danger">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>

            <p id="admin-categories-no-results" class="admin-no-results" hidden>Aucune catégorie ne correspond à votre recherche.</p>
        </section>
    </div>
</div>

<script>
    initSearchFilter({
        inputSelector: "#admin-categories-search-input",
        itemSelector: ".admin-table tbody tr",
        emptySelector: "#admin-categories-no-results",
        visibleDisplay: "table-row"
    });
</script>
