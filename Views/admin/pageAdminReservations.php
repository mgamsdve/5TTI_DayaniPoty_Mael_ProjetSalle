<div class="admin-layout">
    <?php require_once("Views/Components/admin-sidebar.php"); ?>
    <div class="admin-content">
        <h1>Réservations</h1>
        <a href="/admin" class="admin-back">
            <i data-lucide="arrow-left" class="icon-14"></i>
            Retour à l'administration
        </a>

        <section class="admin-section">
            <form method="POST" class="admin-form">
                <input type="hidden" name="action" value="addReservation">

                <label for="reservation_salle">Salle</label>
                <select name="id_salle" id="reservation_salle">
                    <?php foreach ($salles as $salle) : ?>
                        <option value="<?= $salle->id_salle ?>"><?= $salle->sal_nom ?> (<?= $salle->sal_numero ?>)</option>
                    <?php endforeach ?>
                </select>

                <label for="reservation_user">Utilisateur</label>
                <select name="id_utilisateur" id="reservation_user">
                    <?php foreach ($users as $user) : ?>
                        <option value="<?= $user->id_utilisateur ?>"><?= $user->uti_nom ?> <?= $user->uti_prenom ?></option>
                    <?php endforeach ?>
                </select>

                <label for="reservation_debut">Date de début</label>
                <input type="date" name="dateDebut" id="reservation_debut" required>

                <label for="reservation_fin">Date de fin</label>
                <input type="date" name="dateFin" id="reservation_fin" required>

                <input type="submit" value="Ajouter une réservation">
            </form>

            <div class="admin-search" role="search">
                <label for="admin-reservations-search-input">Rechercher une réservation</label>
                <input
                    type="text"
                    id="admin-reservations-search-input"
                    placeholder="Salle, utilisateur, dates ou ID..."
                    autocomplete="off"
                >
            </div>

            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Salle</th>
                            <th>Utilisateur</th>
                            <th>Date début</th>
                            <th>Date fin</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservations as $reservation) : ?>
                            <tr data-search="<?= htmlspecialchars(strtolower($reservation->id_reservation . ' ' . $reservation->sal_nom . ' ' . $reservation->sal_numero . ' ' . $reservation->uti_nom . ' ' . $reservation->uti_prenom . ' ' . $reservation->res_dateDebut . ' ' . $reservation->res_dateFin), ENT_QUOTES, 'UTF-8') ?>">
                                <td><?= $reservation->id_reservation ?></td>
                                <td>
                                    <select name="id_salle" form="reservation-form-<?= $reservation->id_reservation ?>">
                                        <?php foreach ($salles as $salle) : ?>
                                            <option value="<?= $salle->id_salle ?>" <?= $reservation->id_salle == $salle->id_salle ? "selected" : "" ?>><?= $salle->sal_nom ?> (<?= $salle->sal_numero ?>)</option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="id_utilisateur" form="reservation-form-<?= $reservation->id_reservation ?>">
                                        <?php foreach ($users as $user) : ?>
                                            <option value="<?= $user->id_utilisateur ?>" <?= $reservation->id_utilisateur == $user->id_utilisateur ? "selected" : "" ?>><?= $user->uti_nom ?> <?= $user->uti_prenom ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td><input type="date" name="dateDebut" value="<?= $reservation->res_dateDebut ?>" form="reservation-form-<?= $reservation->id_reservation ?>" required></td>
                                <td><input type="date" name="dateFin" value="<?= $reservation->res_dateFin ?>" form="reservation-form-<?= $reservation->id_reservation ?>" required></td>
                                <td>
                                    <form method="POST" id="reservation-form-<?= $reservation->id_reservation ?>" class="admin-inline-form">
                                        <input type="hidden" name="action" value="updateReservation">
                                        <input type="hidden" name="id_reservation" value="<?= $reservation->id_reservation ?>">
                                        <button type="submit">Modifier</button>
                                    </form>
                                </td>
                                <td>
                                    <form method="POST" class="admin-inline-form">
                                        <input type="hidden" name="action" value="deleteReservation">
                                        <input type="hidden" name="id_reservation" value="<?= $reservation->id_reservation ?>">
                                        <button type="submit" class="btn-danger">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>

            <p id="admin-reservations-no-results" class="admin-no-results" hidden>Aucune réservation ne correspond à votre recherche.</p>
        </section>
    </div>
</div>

<script>
    initSearchFilter({
        inputSelector: "#admin-reservations-search-input",
        itemSelector: ".admin-table tbody tr",
        emptySelector: "#admin-reservations-no-results",
        visibleDisplay: "table-row"
    });
</script>
