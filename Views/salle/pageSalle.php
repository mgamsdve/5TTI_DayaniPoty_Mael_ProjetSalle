<h1>Liste des Salles</h1>

<div class="Salle-container">
    <?php foreach ($salles as $salle): ?>
        <div class="salle">
            <a href="/Salle/Details/<?= $salle->sal_numero ?>"> <img src="<?= htmlspecialchars($salle->sal_image) ?>" alt="Image de <?= htmlspecialchars($salle->sal_nom) ?>" class="salle-image">
            </a>
            <h3><?= htmlspecialchars($salle->sal_nom) ?></h3>
            <p><strong>Capacité/Taille :</strong> <?= htmlspecialchars($salle->sal_taille) ?> m²</p>
            <p><strong>Référence :</strong> <?= htmlspecialchars($salle->sal_numero) ?></p>
            <div class="salle-link">
                <a href="/Salle/Details/<?= $salle->sal_numero ?>" class="btn-link">Voir détails</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>