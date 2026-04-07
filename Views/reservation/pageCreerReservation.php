<div class="auth-card">
    <h1>Nouvelle réservation</h1>

    <?php if (!empty($erreurReservation)) : ?>
        <p class="form-error"><?= htmlspecialchars($erreurReservation) ?></p>
    <?php endif; ?>

    <form action="/create-reservation" method="POST">
        <input type="hidden" name="action" value="createReservation">
        <div class="form-group">
            <label for="id_salles">Salles (selection multiple)</label>
            <select name="id_salles[]" id="id_salles" multiple required size="8">
                <?php foreach ($salles as $salle) : ?>
                    <?php
                    $isSelected = isset($_POST["id_salles"]) && is_array($_POST["id_salles"]) && in_array((string) $salle->id_salle, $_POST["id_salles"]);
                    ?>
                    <option value="<?= $salle->id_salle ?>" <?= $isSelected ? "selected" : "" ?>>
                        <?= htmlspecialchars($salle->sal_nom) ?> (N°<?= htmlspecialchars($salle->sal_numero) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <small class="form-help">Maintenez Cmd (Mac) ou Ctrl (Windows) pour selectionner plusieurs salles.</small>
        </div>

        <div class="form-group">
            <label for="dateDebut">Date de début</label>
            <input type="date" name="dateDebut" id="dateDebut"
                   value="<?= isset($_POST["dateDebut"]) ? htmlspecialchars($_POST["dateDebut"]) : "" ?>" required>
        </div>

        <div class="form-group">
            <label for="dateFin">Date de fin</label>
            <input type="date" name="dateFin" id="dateFin"
                   value="<?= isset($_POST["dateFin"]) ? htmlspecialchars($_POST["dateFin"]) : "" ?>" required>
        </div>

        <div class="form-actions">
            <input type="submit" value="Créer la réservation">
            <a href="/Reservation" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
