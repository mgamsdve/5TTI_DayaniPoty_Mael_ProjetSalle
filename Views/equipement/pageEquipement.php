<h1>Équipements</h1>

<?php if (empty($equipements)) : ?>
    <p>Aucun équipement disponible pour le moment.</p>
<?php else : ?>
    <div class="Salle-container">
        <?php foreach ($equipements as $equipement) : ?>
            <div class="salle">
                <div class="equipement-icon">🛠️</div>
                <h3><?= htmlspecialchars($equipement->equi_nom) ?></h3>
                <?php if (!empty($equipement->equi_description)) : ?>
                    <p><?= htmlspecialchars($equipement->equi_description) ?></p>
                <?php endif; ?>
                <p class="equipement-id"><strong>Ref. :</strong> #<?= $equipement->id_equipement ?></p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
