<div class="admin-layout">
    <?php require_once("Views/Components/admin-sidebar.php"); ?>
    <div class="admin-content">
        <h1>Contenances</h1>
        <a href="/admin" class="admin-back">
            <i data-lucide="arrow-left" style="width:14px;height:14px;"></i>
            Retour à l'administration
        </a>

        <section class="admin-section">
            <form method="POST" class="admin-form">
                <input type="hidden" name="action" value="addContenance">

                <label for="contenance_salle">Salle</label>
                <select name="id_salle" id="contenance_salle">
                    <?php foreach ($salles as $salle) : ?>
                        <option value="<?= $salle->id_salle ?>"><?= $salle->sal_nom ?> (<?= $salle->sal_numero ?>)</option>
                    <?php endforeach ?>
                </select>

                <label for="contenance_equipement">Équipement</label>
                <select name="id_equipement" id="contenance_equipement">
                    <?php foreach ($equipements as $equipement) : ?>
                        <option value="<?= $equipement->id_equipement ?>"><?= $equipement->equi_nom ?></option>
                    <?php endforeach ?>
                </select>

                <label for="contenance_quantite">Quantité</label>
                <input type="number" name="quantite" id="contenance_quantite" required>

                <input type="submit" value="Ajouter une contenance">
            </form>

            <div class="admin-search" role="search">
                <label for="admin-contenances-search-input">Rechercher une contenance</label>
                <input
                    type="text"
                    id="admin-contenances-search-input"
                    placeholder="Salle, équipement, quantité ou ID..."
                    autocomplete="off"
                >
            </div>

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
                            <tr data-search="<?= htmlspecialchars(strtolower($contenance->id_contenance . ' ' . $contenance->sal_nom . ' ' . $contenance->sal_numero . ' ' . $contenance->equi_nom . ' ' . $contenance->cont_quantite), ENT_QUOTES, 'UTF-8') ?>">
                                <td><?= $contenance->id_contenance ?></td>
                                <td>
                                    <select name="id_salle" form="contenance-form-<?= $contenance->id_contenance ?>">
                                        <?php foreach ($salles as $salle) : ?>
                                            <option value="<?= $salle->id_salle ?>" <?= $contenance->id_salle == $salle->id_salle ? "selected" : "" ?>><?= $salle->sal_nom ?> (<?= $salle->sal_numero ?>)</option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="id_equipement" form="contenance-form-<?= $contenance->id_contenance ?>">
                                        <?php foreach ($equipements as $equipement) : ?>
                                            <option value="<?= $equipement->id_equipement ?>" <?= $contenance->id_equipement == $equipement->id_equipement ? "selected" : "" ?>><?= $equipement->equi_nom ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td><input type="number" name="quantite" value="<?= $contenance->cont_quantite ?>" form="contenance-form-<?= $contenance->id_contenance ?>" required></td>
                                <td>
                                    <form method="POST" id="contenance-form-<?= $contenance->id_contenance ?>" class="admin-inline-form">
                                        <input type="hidden" name="action" value="updateContenance">
                                        <input type="hidden" name="id_contenance" value="<?= $contenance->id_contenance ?>">
                                        <button type="submit">Modifier</button>
                                    </form>
                                </td>
                                <td>
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

            <p id="admin-contenances-no-results" class="admin-no-results" hidden>Aucune contenance ne correspond à votre recherche.</p>
        </section>
    </div>
</div>

<script>
    initSearchFilter({
        inputSelector: "#admin-contenances-search-input",
        itemSelector: ".admin-table tbody tr",
        emptySelector: "#admin-contenances-no-results",
        visibleDisplay: "table-row"
    });
</script>
