<?php if (!$salle): ?>
    <!-- Cas d'erreur quand la salle demandée n'existe pas. -->
    <div class="empty-state">
        <h1>Salle introuvable</h1>
        <p class="mb-24">La salle demandée n'existe pas.</p>
        <a href="/Salle" class="btn">Retour aux salles</a>
    </div>
<?php else: ?>
    <!-- Vue détaillée d'une salle existante avec équipements et réservations. -->
    <div class="details-layout">
        <div class="details-main">
            <!-- Titre principal et métadonnées de la salle. -->
            <h1><?= htmlspecialchars($salle->sal_nom) ?></h1>

            <?php if ($categorieSalle): ?>
                <span class="badge badge--spaced">
                    <?= htmlspecialchars($categorieSalle->cat_nom) ?>
                </span>
            <?php endif; ?>

            <img src="<?= htmlspecialchars($salle->sal_image) ?>"
                 alt="Image de <?= htmlspecialchars($salle->sal_nom) ?>"
                  class="salle-image salle-image--tall">

            <div class="details-info-row">
                <p><strong>Référence :</strong> <?= htmlspecialchars($salle->sal_numero) ?></p>
                <p><strong>Surface :</strong> <?= htmlspecialchars($salle->sal_taille) ?> m²</p>
                <?php if ($categorieSalle): ?>
                    <p><strong>Catégorie :</strong> <?= htmlspecialchars($categorieSalle->cat_nom) ?></p>
                <?php endif; ?>
            </div>

            <!-- Bloc qui présente les équipements disponibles dans la salle. -->
            <h2>Équipements</h2>
            <?php if (empty($equipementsSalle)): ?>
                <p class="mb-24">Aucun équipement pour cette salle.</p>
            <?php else: ?>
                <!-- Chaque équipement est affiché sous forme de pastille lisible. -->
                <div class="equipment-pills equipment-pills--spaced">
                    <?php foreach ($equipementsSalle as $equipementSalle): ?>
                        <div class="equipment-pill">
                            <i data-lucide="monitor" class="icon-14"></i>
                            <?= htmlspecialchars($equipementSalle->equi_nom) ?>
                            <span class="text-muted text-sm">
                                × <?= htmlspecialchars($equipementSalle->cont_quantite) ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Historique des réservations déjà prises pour cette salle. -->
            <h2>Réservations existantes</h2>
            <?php if (empty($reservationsSalle)): ?>
                <p>Aucune réservation pour cette salle.</p>
            <?php else: ?>
                <div class="reservation-list">
                    <?php foreach ($reservationsSalle as $reservationSalle): ?>
                        <div class="reservation-item">
                            <i data-lucide="calendar" class="icon-16 icon-primary shrink-0"></i>
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

            <!-- Retour rapide vers la liste des salles. -->
            <div class="salle-link salle-link--spaced">
                <a href="/Salle">← Retour aux salles</a>
            </div>
        </div>

        <div>
            <!-- Encadré d'action pour accéder rapidement à la réservation. -->
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
