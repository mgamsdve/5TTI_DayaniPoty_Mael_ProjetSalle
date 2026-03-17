<div class="page-header">
    <h1>Mes Réservations</h1>
    <a href="/create-reservation" class="btn">+ Nouvelle réservation</a>
</div>

<!-- Liste des réservations existantes -->
<h2>Mes réservations en cours</h2>

<?php if (empty($reservations)) : ?>
    <p>Vous n'avez aucune réservation pour le moment.</p>
<?php else : ?>
    <div class="Salle-container">
        <?php foreach ($reservations as $reservation): ?>
            <div class="salle">
                <a href="/Salle/Details/<?= $reservation->sal_numero ?>"> <img src="<?= htmlspecialchars($reservation->sal_image) ?>" alt="Image de <?= htmlspecialchars($reservation->sal_nom) ?>" class="salle-image">
                </a>
                <h3><?= htmlspecialchars($reservation->sal_nom) ?></h3>
                <p><strong>Date de début :</strong> <?= htmlspecialchars($reservation->res_dateDebut) ?></p>
                <p><strong>Date de fin :</strong> <?= htmlspecialchars($reservation->res_dateFin) ?></p>
                <p><strong>Réservation # :</strong> <?= $reservation->id_reservation ?></p>
                <div class="salle-link">
                    <a href="/delete-reservation?id=<?= $reservation->id_reservation ?>"
                        class="btn-delete"
                        onclick="return confirm('Confirmer la suppression de cette réservation ?')">
                        <span class="btn-delete-icon">🗑</span>
                        Supprimer
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>