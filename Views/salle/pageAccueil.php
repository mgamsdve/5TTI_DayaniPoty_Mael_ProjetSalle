<!-- HERO -->
<section class="hero">
    <div class="hero-content">
        <h1>Gestion intelligente des salles</h1>
        <p>
            Visualisez, organisez et réservez vos salles
            dans une interface moderne et fluide.
        </p>

        <div class="hero-stats">
            <div>
                <span>+10</span>
                <small>Salles</small>
            </div>
            <div>
                <span>+5</span>
                <small>Catégories</small>
            </div>
            <div>
                <span>∞</span>
                <small>Réservations</small>
            </div>
        </div>
    </div>

    <!-- BLOBS -->
    <div class="blob b1"></div>
    <div class="blob b2"></div>

    <!-- FLOATING ICONS -->
    <div class="floating-icons">
        <svg class="float f1" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <rect x="3" y="3" width="18" height="18" rx="3" />
        </svg>
        <svg class="float f2" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <circle cx="12" cy="12" r="9" />
        </svg>
        <svg class="float f3" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path d="M3 12h18" />
            <path d="M12 3v18" />
        </svg>
    </div>
</section>

<!-- SALLES -->
<section class="home-section">
    <h2 class="section-title">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <rect x="3" y="3" width="7" height="7" />
            <rect x="14" y="3" width="7" height="7" />
            <rect x="14" y="14" width="7" height="7" />
            <rect x="3" y="14" width="7" height="7" />
        </svg>
        Explorer les salles
    </h2>

    <div class="Salle-container">
        <?php foreach ($salles as $salle) : ?>
            <div class="salle">
                <div class="salle-image-placeholder">
                    <svg viewBox="0 0 400 200" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="g" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#266986a8" />
                                <stop offset="100%" stop-color="#1985417c" />
                            </linearGradient>
                        </defs>
                        <rect width="400" height="200" fill="url(#g)" />
                    </svg>
                </div>

                <div class="salle-body">
                    <span class="badge">Catégorie</span>
                    <h3><?= $salle->sal_nom ?></h3>
                    <p><?= $salle->sal_taille ?> m² • Salle <?= $salle->sal_numero ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>