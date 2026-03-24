<div class="page-header">
    <h1>Mes Réservations</h1>
    <a href="/create-reservation" class="btn">
        <i data-lucide="plus"></i>
        Nouvelle réservation
    </a>
</div>

<?php if (empty($reservations)) : ?>
    <div style="text-align:center; padding: 60px 0; color: var(--text-secondary);">
        <i data-lucide="calendar-x" style="width:48px;height:48px;margin:0 auto 16px;display:block;color:var(--text-muted);"></i>
        <p style="font-size:1rem; margin-bottom:20px;">Vous n'avez aucune réservation pour le moment.</p>
        <a href="/Salle" class="btn">Voir les salles disponibles</a>
    </div>
<?php else : ?>
    <div class="Salle-container">
        <?php foreach ($reservations as $reservation): ?>
            <div class="salle">
                <a href="/Salle/Details/<?= $reservation->sal_numero ?>">
                    <img src="<?= htmlspecialchars($reservation->sal_image) ?>"
                         alt="Image de <?= htmlspecialchars($reservation->sal_nom) ?>"
                         class="salle-image">
                </a>
                <h3><?= htmlspecialchars($reservation->sal_nom) ?></h3>
                <p>
                    <i data-lucide="calendar" style="width:13px;height:13px;display:inline;vertical-align:middle;"></i>
                    <strong>Début :</strong> <?= htmlspecialchars($reservation->res_dateDebut) ?>
                </p>
                <p>
                    <i data-lucide="calendar-check" style="width:13px;height:13px;display:inline;vertical-align:middle;"></i>
                    <strong>Fin :</strong> <?= htmlspecialchars($reservation->res_dateFin) ?>
                </p>
                <p style="color:var(--text-muted); font-size:0.8rem;">
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
                        <i data-lucide="trash-2" style="width:13px;height:13px;"></i>
                        Annuler
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
