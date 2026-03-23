<?php if (!$salle): ?>
    <div style="text-align:center; padding: 60px 0;">
        <h1>Salle introuvable</h1>
        <p style="margin-bottom:24px;">La salle demandée n'existe pas.</p>
        <a href="/Salle" class="btn">Retour aux salles</a>
    </div>
<?php else: ?>
    <div class="details-layout">
        <div class="details-main">
            <h1><?= htmlspecialchars($salle->sal_nom) ?></h1>

            <?php if ($categorieSalle): ?>
                <span class="badge" style="margin-bottom: 20px; display:inline-block;">
                    <?= htmlspecialchars($categorieSalle->cat_nom) ?>
                </span>
            <?php endif; ?>

            <img src="<?= htmlspecialchars($salle->sal_image) ?>"
                 alt="Image de <?= htmlspecialchars($salle->sal_nom) ?>"
                 class="salle-image"
                 style="height: 280px; margin-bottom: 20px;">

            <div class="details-info-row">
                <p><strong>Référence :</strong> <?= htmlspecialchars($salle->sal_numero) ?></p>
                <p><strong>Surface :</strong> <?= htmlspecialchars($salle->sal_taille) ?> m²</p>
                <?php if ($categorieSalle): ?>
                    <p><strong>Catégorie :</strong> <?= htmlspecialchars($categorieSalle->cat_nom) ?></p>
                <?php endif; ?>
            </div>

            <h2>Équipements</h2>
            <?php if (empty($equipementsSalle)): ?>
                <p style="margin-bottom: 24px;">Aucun équipement pour cette salle.</p>
            <?php else: ?>
                <div class="equipment-pills" style="margin-bottom: 24px;">
                    <?php foreach ($equipementsSalle as $equipementSalle): ?>
                        <div class="equipment-pill">
                            <i data-lucide="monitor" style="width:14px;height:14px;"></i>
                            <?= htmlspecialchars($equipementSalle->equi_nom) ?>
                            <span style="color:var(--text-muted); font-size:0.8rem;">
                                × <?= htmlspecialchars($equipementSalle->cont_quantite) ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <h2>Réservations existantes</h2>
            <?php if (empty($reservationsSalle)): ?>
                <p>Aucune réservation pour cette salle.</p>
            <?php else: ?>
                <div class="reservation-list">
                    <?php foreach ($reservationsSalle as $reservationSalle): ?>
                        <div class="reservation-item">
                            <i data-lucide="calendar" style="width:16px;height:16px;color:var(--primary);flex-shrink:0;"></i>
                            <div>
                                <strong><?= htmlspecialchars($reservationSalle->uti_prenom . " " . $reservationSalle->uti_nom) ?></strong>
                                &mdash;
                                Du <?= htmlspecialchars($reservationSalle->res_dateDebut) ?>
                                au <?= htmlspecialchars($reservationSalle->res_dateFin) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="salle-link" style="margin-top: 32px;">
                <a href="/Salle">← Retour aux salles</a>
            </div>
        </div>

        <div>
            <div class="booking-panel">
                <h3>Réserver cette salle</h3>
                <p><strong>Référence :</strong> <?= htmlspecialchars($salle->sal_numero) ?></p>
                <p><strong>Surface :</strong> <?= htmlspecialchars($salle->sal_taille) ?> m²</p>
                <?php if ($categorieSalle): ?>
                    <p><strong>Catégorie :</strong> <?= htmlspecialchars($categorieSalle->cat_nom) ?></p>
                <?php endif; ?>
                <a href="/create-reservation" class="btn">
                    <i data-lucide="calendar-plus"></i>
                    Réserver maintenant
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>
