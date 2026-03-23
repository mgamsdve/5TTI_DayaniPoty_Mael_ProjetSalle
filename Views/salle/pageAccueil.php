<?php
$featuredSalles = array_slice($salles ?? [], 0, 3);
$sallesCount = count($salles ?? []);
?>

<div class="home-page">
    <section class="hero-section animate-on-scroll">
        <div class="hero-inner">
            <h1 class="hero-title">Reservez vos espaces de travail en toute simplicite</h1>
            <p class="hero-subtitle">Centralisez les salles, planifiez vos reunions et gagnez du temps avec une experience fluide et elegante.</p>
            <a href="/Salle" class="btn cta-button">Voir les salles</a>

            <div class="hero-illustration" aria-hidden="true">
                <svg viewBox="0 0 220 180" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="28" y="22" width="164" height="136" rx="20" stroke="currentColor" stroke-width="8" />
                    <rect x="54" y="50" width="40" height="28" rx="6" fill="currentColor" opacity="0.25" />
                    <rect x="106" y="50" width="60" height="10" rx="5" fill="currentColor" opacity="0.5" />
                    <rect x="106" y="68" width="48" height="10" rx="5" fill="currentColor" opacity="0.35" />
                    <rect x="54" y="92" width="112" height="14" rx="7" fill="currentColor" opacity="0.45" />
                    <rect x="54" y="114" width="70" height="14" rx="7" fill="currentColor" opacity="0.3" />
                    <circle cx="174" cy="122" r="18" stroke="currentColor" stroke-width="8" />
                    <path d="M174 108V122L184 130" stroke="currentColor" stroke-width="8" stroke-linecap="round" />
                </svg>
            </div>
        </div>
    </section>

    <section class="stats-section animate-on-scroll" id="stats-section">
        <div class="stats-grid">
            <article class="stat-card">
                <div class="stat-icon">&#127970;</div>
                <div class="stat-value" data-counter-target="<?= max(12, $sallesCount) ?>">0</div>
                <p class="stat-label">Salles disponibles</p>
            </article>
            <article class="stat-card">
                <div class="stat-icon">&#128197;</div>
                <div class="stat-value" data-counter-target="340">0</div>
                <p class="stat-label">Reservations ce mois</p>
            </article>
            <article class="stat-card">
                <div class="stat-icon">&#128421;</div>
                <div class="stat-value" data-counter-target="45">0</div>
                <p class="stat-label">Equipements references</p>
            </article>
        </div>
    </section>

    <section class="how-it-works animate-on-scroll">
        <div class="steps-row">
            <div class="step">
                <div class="step-number">1</div>
                <h3>Choisissez</h3>
                <p>Trouvez une salle adaptee a votre besoin en quelques secondes.</p>
            </div>
            <div class="step-connector" aria-hidden="true"></div>
            <div class="step">
                <div class="step-number">2</div>
                <h3>Reservez</h3>
                <p>Validez votre demande en ligne avec un parcours simple et rapide.</p>
            </div>
            <div class="step-connector" aria-hidden="true"></div>
            <div class="step">
                <div class="step-number">3</div>
                <h3>Profitez</h3>
                <p>Accedez a un espace prete a l'emploi pour vos reunions.</p>
            </div>
        </div>
    </section>

    <section class="featured-section animate-on-scroll">
        <h2 class="section-title">Salles en vedette</h2>
        <div class="featured-grid">
            <?php if (!empty($featuredSalles)): ?>
                <?php foreach ($featuredSalles as $salle): ?>
                    <article class="room-card">
                        <div class="room-media">
                            <?php if (!empty($salle->sal_image)): ?>
                                <img src="<?= htmlspecialchars($salle->sal_image) ?>" alt="Salle <?= htmlspecialchars($salle->sal_nom) ?>">
                            <?php else: ?>
                                <svg width="72" height="72" viewBox="0 0 24 24" fill="none" aria-hidden="true" style="color: var(--primary);">
                                    <rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="1.8" />
                                    <path d="M7 10H17M7 14H13" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                                </svg>
                            <?php endif; ?>
                        </div>
                        <h3><?= htmlspecialchars($salle->sal_nom) ?></h3>
                        <p class="room-meta">Capacite: <?= (int) ($salle->sal_taille ?? 10) ?> personnes</p>
                        <a class="btn outline-button" href="/Salle/Details/<?= urlencode($salle->sal_numero) ?>">Reserver</a>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <?php for ($i = 1; $i <= 3; $i++): ?>
                    <article class="room-card">
                        <div class="room-media">
                            <svg width="72" height="72" viewBox="0 0 24 24" fill="none" aria-hidden="true" style="color: var(--primary);">
                                <rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="1.8" />
                                <path d="M7 10H17M7 14H13" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                            </svg>
                        </div>
                        <h3>Salle Premium <?= $i ?></h3>
                        <p class="room-meta">Capacite: <?= 8 + ($i * 2) ?> personnes</p>
                        <a class="btn outline-button" href="/Salle">Reserver</a>
                    </article>
                <?php endfor; ?>
            <?php endif; ?>
        </div>
    </section>

    <section class="final-cta animate-on-scroll">
        <h2>Pret a reserver votre espace ?</h2>
        <a href="/Salle" class="btn final-button">Voir toutes les salles</a>
    </section>
</div>

<script src="/Assets/JS/home.js"></script>