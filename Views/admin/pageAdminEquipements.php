<div class="admin-layout">
    <?php require_once("Views/Components/admin-sidebar.php"); ?>
    <div class="admin-content">
        <h1>Équipements</h1>
        <a href="/admin" class="admin-back">
            <i data-lucide="arrow-left" style="width:14px;height:14px;"></i>
            Retour à l'administration
        </a>

        <section class="admin-section">
            <form method="POST" class="admin-form">
                <input type="hidden" name="action" value="addEquipement">

                <label for="equipement_nom">Nom</label>
                <input type="text" name="nom" id="equipement_nom" required>

                <label for="equipement_description">Description</label>
                <input type="text" name="description" id="equipement_description" required>

                <input type="submit" value="Ajouter un équipement">
            </form>

            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($equipements as $equipement) : ?>
                            <tr>
                                <td><?= $equipement->id_equipement ?></td>
                                <td><input type="text" name="nom" value="<?= $equipement->equi_nom ?>" form="equipement-form-<?= $equipement->id_equipement ?>" required></td>
                                <td><input type="text" name="description" value="<?= $equipement->equi_description ?>" form="equipement-form-<?= $equipement->id_equipement ?>" required></td>
                                <td>
                                    <form method="POST" id="equipement-form-<?= $equipement->id_equipement ?>" class="admin-inline-form">
                                        <input type="hidden" name="action" value="updateEquipement">
                                        <input type="hidden" name="id_equipement" value="<?= $equipement->id_equipement ?>">
                                        <button type="submit">Modifier</button>
                                    </form>
                                </td>
                                <td>
                                    <form method="POST" class="admin-inline-form">
                                        <input type="hidden" name="action" value="deleteEquipement">
                                        <input type="hidden" name="id_equipement" value="<?= $equipement->id_equipement ?>">
                                        <button type="submit" class="btn-danger">Supprimer</button>
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
