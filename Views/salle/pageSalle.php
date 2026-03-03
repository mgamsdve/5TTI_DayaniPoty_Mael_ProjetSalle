<h1>Liste des Salles</h1>

<div class="Salle-container">
    <?php foreach ($salles as $salle): ?>
        <div class="salle">
            <img src="<?= $salle->sal_image ?>" alt="Image de <?= $salle->sal_nom ?>" class="salle-image">
            <h3><?= $salle->sal_nom ?></h3>
            <p><strong>Capacité/Taille :</strong> <?= $salle->sal_taille ?> m²</p>
            <p><strong>Référence :</strong> <?= $salle->sal_numero ?></p>
            <div class="salle-link">
                <a href="/Salle/Details/<?= $salle->sal_numero ?>" class="btn-link">Voir détails</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
