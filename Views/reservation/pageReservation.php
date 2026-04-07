<div class="page-header">
    <h1>Mes Réservations</h1>
    <a href="/create-reservation" class="btn">
        <i data-lucide="plus"></i>
        Nouvelle réservation
    </a>
</div>

<?php if (empty($reservations)) : ?>
    <div class="empty-state">
        <i data-lucide="calendar-x" class="empty-state__icon icon-48 icon-muted"></i>
        <p class="empty-state__text">Vous n'avez aucune réservation pour le moment.</p>
        <a href="/Salle" class="btn">Voir les salles disponibles</a>
    </div>
<?php else : ?>
    <div class="list-search" role="search">
        <label for="reservation-search-input">Rechercher une réservation</label>
        <input
            type="text"
            id="reservation-search-input"
            placeholder="Salle, référence, date ou numéro..."
            autocomplete="off"
        >
    </div>

    <div class="Salle-container">
        <?php foreach ($reservations as $reservation): ?>
            <div
                class="salle"
                data-search="<?= htmlspecialchars(strtolower($reservation->sal_nom . ' ' . $reservation->sal_numero . ' ' . $reservation->res_dateDebut . ' ' . $reservation->res_dateFin . ' ' . $reservation->id_reservation), ENT_QUOTES, 'UTF-8') ?>"
            >
                <a href="/Salle/Details/<?= $reservation->sal_numero ?>">
                    <img src="<?= htmlspecialchars($reservation->sal_image) ?>"
                         alt="Image de <?= htmlspecialchars($reservation->sal_nom) ?>"
                         class="salle-image">
                </a>
                <h3><?= htmlspecialchars($reservation->sal_nom) ?></h3>
                <p>
                    <i data-lucide="calendar" class="icon-14"></i>
                    <strong>Début :</strong> <?= htmlspecialchars($reservation->res_dateDebut) ?>
                </p>
                <p>
                    <i data-lucide="calendar-check" class="icon-14"></i>
                    <strong>Fin :</strong> <?= htmlspecialchars($reservation->res_dateFin) ?>
                </p>
                <p class="text-muted text-sm">
                    Réservation #<?= $reservation->id_reservation ?>
                </p>
                <div class="salle-link">
                    <form method="POST" action="/delete-reservation" id="delete-reservation-<?= $reservation->id_reservation ?>">
                        <input type="hidden" name="action" value="deleteReservation">
                        <input type="hidden" name="id_reservation" value="<?= $reservation->id_reservation ?>">
                    </form>
                    <a href="#"
                       class="btn-delete"
                       onclick="if (confirm('Confirmer la suppression de cette réservation ?')) { document.getElementById('delete-reservation-<?= $reservation->id_reservation ?>').submit(); } return false;">
                        <i data-lucide="trash-2" class="icon-14"></i>
                        Annuler
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <p id="reservation-no-results" class="list-no-results" hidden>Aucune réservation ne correspond à votre recherche.</p>

    <script>
        initSearchFilter({
            inputSelector: "#reservation-search-input",
            itemSelector: ".Salle-container .salle",
            emptySelector: "#reservation-no-results"
        });
    </script>
<?php endif; ?>
