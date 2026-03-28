<div class="auth-card">
    <h1>Nouvelle réservation</h1>

    <?php if (!empty($erreurReservation)) : ?>
        <p class="form-error"><?= htmlspecialchars($erreurReservation) ?></p>
    <?php endif; ?>

    <form action="/create-reservation" method="POST">
        <input type="hidden" name="action" value="createReservation">
        <div class="form-group">
            <label for="id_salle">Salle</label>
            <input
                type="text"
                id="reservation-create-search-input"
                placeholder="Rechercher une salle par nom ou numéro..."
                autocomplete="off"
            >
            <select name="id_salle" id="id_salle" required>
                <option value="">-- Choisir une salle --</option>
                <?php foreach ($salles as $salle) : ?>
                    <option value="<?= $salle->id_salle ?>"
                        <?= isset($_POST["id_salle"]) && $_POST["id_salle"] == $salle->id_salle ? "selected" : "" ?>>
                        <?= htmlspecialchars($salle->sal_nom) ?> (N°<?= htmlspecialchars($salle->sal_numero) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <p id="reservation-create-no-results" class="list-no-results" hidden>Aucune salle ne correspond à votre recherche.</p>
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

<script>
    initSelectSearch({
        inputSelector: "#reservation-create-search-input",
        selectSelector: "#id_salle",
        emptySelector: "#reservation-create-no-results"
    });
</script>
