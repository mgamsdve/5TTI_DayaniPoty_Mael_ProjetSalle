<!-- Layout d'administration pour la table de liaison entre salles et équipements. -->
<div class="admin-layout">
    <?php require_once("Views/Components/admin-sidebar.php"); ?>
    <!-- Zone principale de gestion des contenances. -->
    <div class="admin-content">
        <h1>Contenances</h1>
        <a href="/admin" class="admin-back">
            <i data-lucide="arrow-left" class="icon-14"></i>
            Retour à l'administration
        </a>

        <!-- Section qui contient le formulaire, la recherche et le tableau. -->
        <section class="admin-section">
            <!-- Formulaire de création d'une liaison salle-équipement. -->
            <form method="POST" class="admin-form">
                <input type="hidden" name="action" value="addContenance">

                <label for="contenance_salle">Salle</label>
                <select name="id_salle" id="contenance_salle" required>
                    <?php foreach ($salles as $salle) : ?>
                        <option value="<?= $salle->id_salle ?>"><?= $salle->sal_nom ?> (<?= $salle->sal_numero ?>)</option>
                    <?php endforeach ?>
                </select>

                <label for="contenance_equipement">Équipement</label>
                <select name="id_equipement" id="contenance_equipement" required>
                    <?php foreach ($equipements as $equipement) : ?>
                        <option value="<?= $equipement->id_equipement ?>"><?= $equipement->equi_nom ?></option>
                    <?php endforeach ?>
                </select>

                <label for="contenance_quantite">Quantité</label>
                <input type="number" name="quantite" id="contenance_quantite" required>

                <input type="submit" value="Ajouter une contenance">
            </form>

            <!-- Recherche textuelle pour retrouver rapidement une relation. -->
            <div class="admin-search" role="search">
                <label for="admin-contenances-search-input">Rechercher une contenance</label>
                <input
                    type="text"
                    id="admin-contenances-search-input"
                    placeholder="Salle, équipement, quantité ou ID..."
                    autocomplete="off"
                >
            </div>

            <!-- Tableau de gestion des relations salle-équipement. -->
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Salle</th>
                            <th>Équipement</th>
                            <th>Quantité</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contenances as $contenance) : ?>
                            <!-- Une ligne décrit une relation avec sa quantité. -->
                            <tr data-search="<?= htmlspecialchars(strtolower($contenance->id_contenance . ' ' . $contenance->sal_nom . ' ' . $contenance->sal_numero . ' ' . $contenance->equi_nom . ' ' . $contenance->cont_quantite), ENT_QUOTES, 'UTF-8') ?>">
                                <td><?= $contenance->id_contenance ?></td>
                                <td>
                                    <!-- Sélecteur de salle pour modifier la première FK. -->
                                    <select name="id_salle" form="contenance-form-<?= $contenance->id_contenance ?>" required>
                                        <?php foreach ($salles as $salle) : ?>
                                            <option value="<?= $salle->id_salle ?>" <?= $contenance->id_salle == $salle->id_salle ? "selected" : "" ?>><?= $salle->sal_nom ?> (<?= $salle->sal_numero ?>)</option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td>
                                    <!-- Sélecteur d'équipement pour modifier la seconde FK. -->
                                    <select name="id_equipement" form="contenance-form-<?= $contenance->id_contenance ?>" required>
                                        <?php foreach ($equipements as $equipement) : ?>
                                            <option value="<?= $equipement->id_equipement ?>" <?= $contenance->id_equipement == $equipement->id_equipement ? "selected" : "" ?>><?= $equipement->equi_nom ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td><input type="number" name="quantite" value="<?= $contenance->cont_quantite ?>" form="contenance-form-<?= $contenance->id_contenance ?>" required></td>
                                <td>
                                    <!-- Formulaire de mise à jour de la relation courante. -->
                                    <form method="POST" id="contenance-form-<?= $contenance->id_contenance ?>" class="admin-inline-form">
                                        <input type="hidden" name="action" value="updateContenance">
                                        <input type="hidden" name="id_contenance" value="<?= $contenance->id_contenance ?>">
                                        <button type="submit">Modifier</button>
                                    </form>
                                </td>
                                <td>
                                    <!-- Formulaire de suppression de la relation. -->
                                    <form method="POST" class="admin-inline-form">
                                        <input type="hidden" name="action" value="deleteContenance">
                                        <input type="hidden" name="id_contenance" value="<?= $contenance->id_contenance ?>">
                                        <button type="submit" class="btn-danger">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>

            <!-- Message affiché si aucune relation ne correspond au filtre. -->
            <p id="admin-contenances-no-results" class="admin-no-results" hidden>Aucune contenance ne correspond à votre recherche.</p>
        </section>
    </div>
</div>

<!-- Lance le filtrage JavaScript du tableau. -->
<script>
    initSearchFilter({
        inputSelector: "#admin-contenances-search-input",
        itemSelector: ".admin-table tbody tr",
        emptySelector: "#admin-contenances-no-results",
        visibleDisplay: "table-row"
    });
</script>
