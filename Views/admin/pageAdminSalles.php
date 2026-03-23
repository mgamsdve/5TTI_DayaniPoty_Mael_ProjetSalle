<div class="admin-layout">
    <?php require_once("Views/Components/admin-sidebar.php"); ?>
    <div class="admin-content">
        <h1>Salles</h1>
        <a href="/admin" class="admin-back">
            <i data-lucide="arrow-left" style="width:14px;height:14px;"></i>
            Retour à l'administration
        </a>

        <section class="admin-section">
            <form method="POST" class="admin-form">
                <input type="hidden" name="action" value="addSalle">

                <label for="salle_categorie">Catégorie</label>
                <select name="id_categorie" id="salle_categorie">
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

            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
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
                            <tr>
                                <td><?= $salle->id_salle ?></td>
                                <td>
                                    <select name="id_categorie" form="salle-form-<?= $salle->id_salle ?>">
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
                                    <form method="POST" id="salle-form-<?= $salle->id_salle ?>" class="admin-inline-form">
                                        <input type="hidden" name="action" value="updateSalle">
                                        <input type="hidden" name="id_salle" value="<?= $salle->id_salle ?>">
                                        <button type="submit">Modifier</button>
                                    </form>
                                </td>
                                <td>
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
        </section>
    </div>
</div>
