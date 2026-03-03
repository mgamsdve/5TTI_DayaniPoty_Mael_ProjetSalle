<h1>Mes Reservations</h1>

<?php if (empty($reservations)) : ?>
    <p>Vous n'avez aucune reservation pour le moment.</p>
<?php else : ?>
    <div class="Salle-container">
        <?php foreach ($reservations as $reservation): ?>
            <div class="salle">
                <img src="<?= $reservation->sal_image ?>" alt="Image de <?= $reservation->sal_nom ?>" class="salle-image">
                <h3><?= $reservation->sal_nom ?></h3>
                <p><strong>Date de debut :</strong> <?= $reservation->res_dateDebut ?></p>
                <p><strong>Date de fin :</strong> <?= $reservation->res_dateFin ?></p>
                <p><strong>Reservation # :</strong> <?= $reservation->id_reservation ?></p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
