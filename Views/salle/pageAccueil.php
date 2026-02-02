<h1>Accueil</h1>

<div class="Salle-container">
    <div class="salle-links">
        <a href="/Salle">Salle</a>
    </div>
    <div class="salle-links">
        <a href="/">Autre</a>
    </div>
</div>
<div class="Salle-container">
    <?php foreach ($salles as $salle): ?>
        <div class="salle">
            <h3><?= $salle->sal_nom ?></h3>
            <p>Taille : <?= $salle->sal_taille ?> m²</p>
            <p>Numéro : <?= $salle->sal_numero ?></p>
        </div>
    <?php endforeach; ?>
</div>