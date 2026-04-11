<!-- Layout d'administration pour la gestion des salles. -->
<div class="admin-layout">
    <?php require_once("Views/Components/admin-sidebar.php"); ?>
    <!-- Zone principale avec le formulaire et le tableau. -->
    <div class="admin-content">
        <h1>Salles</h1>
        <a href="/admin" class="admin-back">
            <i data-lucide="arrow-left" class="icon-14"></i>
            Retour à l'administration
        </a>

        <!-- Section principale de gestion des salles. -->
        <section class="admin-section">
            <!-- Formulaire de création d'une salle. -->
            <form method="POST" class="admin-form">
                <input type="hidden" name="action" value="addSalle">

                <label for="salle_categorie">Catégorie</label>
                <select name="id_categorie" id="salle_categorie" required>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category->id_categorie ?>"><?= $category->cat_nom ?></option>
                    <?php endforeach ?>
                </select>

                <label for="salle_nom">Nom</label>
                <input type="text" name="nom" id="salle_nom" required>

                <label for="salle_taille">Taille</label>
                <input type="number" name="taille" id="salle_taille" required>

                <label for="salle_numero">Numéro</label>
                <input type="text" name="numero" id="salle_numero" required>

                <p>Image : lien Unsplash aléatoire ajouté automatiquement.</p>

                <input type="submit" value="Ajouter une salle">
            </form>

            <!-- Recherche textuelle sur les salles. -->
            <div class="admin-search" role="search">
                <label for="admin-salles-search-input">Rechercher une salle</label>
                <input
                    type="text"
                    id="admin-salles-search-input"
                    placeholder="Nom, numéro, taille ou ID..."
                    autocomplete="off"
                >
            </div>

            <!-- Bloc explicatif pour la suppression multiple. -->
            <div class="admin-form admin-bulk-card">
                <label for="admin-salles-bulk-select" class="mt-0">Suppression multiple (multi select)</label>
                <p>Cochez des salles dans le tableau puis lancez la suppression de groupe.</p>
                <input type="submit" id="admin-salles-bulk-select" value="Supprimer les salles selectionnees" class="btn-danger" form="bulk-delete-salles-form">
            </div>

            <!-- Tableau d'édition et de suppression des salles. -->
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Selection</th>
                            <th>ID</th>
                            <th>Catégorie</th>
                            <th>Nom</th>
                            <th>Taille</th>
                            <th>Numéro</th>
                            <th>Image</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($salles as $salle) : ?>
                            <!-- Une ligne correspond à une salle avec sa catégorie et ses actions. -->
                            <tr data-search="<?= htmlspecialchars(strtolower($salle->id_salle . ' ' . $salle->sal_nom . ' ' . $salle->sal_numero . ' ' . $salle->sal_taille . ' ' . $salle->sal_image), ENT_QUOTES, 'UTF-8') ?>">
                                <td>
                                    <input
                                        type="checkbox"
                                        name="salle_ids[]"
                                        value="<?= $salle->id_salle ?>"
                                        form="bulk-delete-salles-form"
                                        aria-label="Selectionner la salle <?= $salle->id_salle ?>"
                                    >
                                </td>
                                <td><?= $salle->id_salle ?></td>
                                <td>
                                    <!-- Sélecteur de catégorie pour modifier la FK de la salle. -->
                                    <select name="id_categorie" form="salle-form-<?= $salle->id_salle ?>" required>
                                        <?php foreach ($categories as $category) : ?>
                                            <option value="<?= $category->id_categorie ?>" <?= $salle->id_categorie == $category->id_categorie ? "selected" : "" ?>><?= $category->cat_nom ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td><input type="text" name="nom" value="<?= $salle->sal_nom ?>" form="salle-form-<?= $salle->id_salle ?>" required></td>
                                <td><input type="number" name="taille" value="<?= $salle->sal_taille ?>" form="salle-form-<?= $salle->id_salle ?>" required></td>
                                <td><input type="text" name="numero" value="<?= $salle->sal_numero ?>" form="salle-form-<?= $salle->id_salle ?>" required></td>
                                <td><input type="text" name="image" value="<?= $salle->sal_image ?>" form="salle-form-<?= $salle->id_salle ?>"></td>
                                <td>
                                    <!-- Formulaire de mise à jour de la salle courante. -->
                                    <form method="POST" id="salle-form-<?= $salle->id_salle ?>" class="admin-inline-form">
                                        <input type="hidden" name="action" value="updateSalle">
                                        <input type="hidden" name="id_salle" value="<?= $salle->id_salle ?>">
                                        <button type="submit">Modifier</button>
                                    </form>
                                </td>
                                <td>
                                    <!-- Formulaire de suppression d'une salle unique. -->
                                    <form method="POST" class="admin-inline-form">
                                        <input type="hidden" name="action" value="deleteSalle">
                                        <input type="hidden" name="id_salle" value="<?= $salle->id_salle ?>">
                                        <button type="submit" class="btn-danger">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>

            <!-- Formulaire caché utilisé par la suppression groupée. -->
            <form method="POST" id="bulk-delete-salles-form" hidden>
                <input type="hidden" name="action" value="deleteSallesMulti">
            </form>

            <!-- Message affiché si le filtre ne trouve aucune salle. -->
            <p id="admin-salles-no-results" class="admin-no-results" hidden>Aucune salle ne correspond à votre recherche.</p>
        </section>
    </div>
</div>

<!-- Initialise le filtre de recherche sur les lignes du tableau. -->
<script>
    initSearchFilter({
        inputSelector: "#admin-salles-search-input",
        itemSelector: ".admin-table tbody tr",
        emptySelector: "#admin-salles-no-results",
        visibleDisplay: "table-row"
    });
</script>
