<?php if (!$salle): ?>
    <h1>Salle introuvable</h1>
    <p>La salle demandee n'existe pas.</p>
    <a href="/Salle" class="btn-link">Retour a la liste des salles</a>
<?php else: ?>
    <h1><?= htmlspecialchars($salle->sal_nom) ?></h1>

    <div class="salle">
        <img src="<?= htmlspecialchars($salle->sal_image) ?>" alt="Image de <?= htmlspecialchars($salle->sal_nom) ?>" class="salle-image">
        <p><strong>Numero :</strong> <?= htmlspecialchars($salle->sal_numero) ?></p>
        <p><strong>Surface :</strong> <?= htmlspecialchars($salle->sal_taille) ?> m2</p>
        <?php if ($categorieSalle): ?>
            <p><strong>Categorie :</strong> <?= htmlspecialchars($categorieSalle->cat_nom) ?></p>
        <?php endif; ?>
    </div>

    <h2>Equipements de la salle</h2>
    <?php if (empty($equipementsSalle)): ?>
        <p>Aucun equipement pour cette salle.</p>
    <?php else: ?>
        <div class="Salle-container">
            <?php foreach ($equipementsSalle as $equipementSalle): ?>
                <div class="salle">
                    <h3><?= htmlspecialchars($equipementSalle->equi_nom) ?></h3>
                    <p><?= htmlspecialchars($equipementSalle->equi_description) ?></p>
                    <p><strong>Quantite :</strong> <?= htmlspecialchars($equipementSalle->cont_quantite) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <h2>Reservations</h2>
    <?php if (empty($reservationsSalle)): ?>
        <p>Aucune reservation pour cette salle.</p>
    <?php else: ?>
        <div class="Salle-container">
            <?php foreach ($reservationsSalle as $reservationSalle): ?>
                <div class="salle">
                    <p><strong>Debut :</strong> <?= htmlspecialchars($reservationSalle->res_dateDebut) ?></p>
                    <p><strong>Fin :</strong> <?= htmlspecialchars($reservationSalle->res_dateFin) ?></p>
                    <p><strong>Reservee par :</strong> <?= htmlspecialchars($reservationSalle->uti_prenom . " " . $reservationSalle->uti_nom) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="salle-link">
        <a href="/Salle" class="btn-link">Retour aux salles</a>
    </div>
<?php endif; ?>

