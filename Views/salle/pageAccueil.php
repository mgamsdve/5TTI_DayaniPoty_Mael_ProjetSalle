<h1>Bienvenue sur ProjetSalle</h1>

<div class="salle-links">
    <a href="/Salle" class="btn">Voir les Salles</a>
    <a href="/" class="btn">Explorer</a>
</div>

<h2>Nos Salles</h2>
<div class="Salle-container">
    <?php foreach ($salles as $salle): ?>
        <div class="salle">
            <a href="/Salle/Details/<?= $salle->sal_numero ?>"> <img src="<?= htmlspecialchars($salle->sal_image) ?>" alt="Image de <?= htmlspecialchars($salle->sal_nom) ?>" class="salle-image">
            </a>
            <h3><?= $salle->sal_nom ?></h3>
            <p><strong>Surface :</strong> <?= $salle->sal_taille ?> m²</p>
            <p><strong>N° de salle :</strong> <?= $salle->sal_numero ?></p>
        </div>
    <?php endforeach; ?>
</div>