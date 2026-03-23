<nav class="navbar">
    <a href="/" class="navbar-brand">
        <i data-lucide="building-2"></i>
        <span>RoomBook</span>
    </a>

    <div class="navbar-links" id="navbar-links">
        <a href="/">Accueil</a>
        <a href="/Salle">Salles</a>
        <a href="/Equipement">Équipements</a>
        <?php if (isset($_SESSION["user"])) : ?>
            <a href="/Reservation">Mes réservations</a>
            <a href="/Utilisateur">Utilisateurs</a>
            <?php if ($_SESSION["user"]->uti_role == "admin") : ?>
                <div class="navbar-dropdown">
                    <button class="navbar-dropdown-btn">
                        Admin <i data-lucide="chevron-down"></i>
                    </button>
                    <div class="navbar-dropdown-menu">
                        <a href="/admin"><i data-lucide="layout-dashboard"></i> Dashboard</a>
                        <a href="/admin/users"><i data-lucide="users"></i> Utilisateurs</a>
                        <a href="/admin/categories"><i data-lucide="tag"></i> Catégories</a>
                        <a href="/admin/salles"><i data-lucide="door-open"></i> Salles</a>
                        <a href="/admin/equipements"><i data-lucide="monitor"></i> Équipements</a>
                        <a href="/admin/contenances"><i data-lucide="link-2"></i> Contenances</a>
                        <a href="/admin/reservations"><i data-lucide="calendar"></i> Réservations</a>
                    </div>
                </div>
            <?php endif ?>
        <?php endif ?>
    </div>

    <div class="navbar-actions">
        <?php if (isset($_SESSION["user"])) : ?>
            <div class="navbar-user">
                <div class="navbar-avatar">
                    <?= strtoupper(substr($_SESSION["user"]->uti_prenom, 0, 1) . substr($_SESSION["user"]->uti_nom, 0, 1)) ?>
                </div>
                <span><?= htmlspecialchars($_SESSION["user"]->uti_prenom) ?></span>
            </div>
            <a href="/Profil" class="btn-outline-sm">Profil</a>
            <a href="/deconnexion" class="btn-sm">Déconnexion</a>
        <?php else : ?>
            <a href="/connexion" class="btn-outline-sm">Connexion</a>
            <a href="/inscription" class="btn-sm">Inscription</a>
        <?php endif ?>
    </div>

    <button class="navbar-mobile-toggle"
        onclick="document.getElementById('navbar-links').classList.toggle('open')"
        aria-label="Menu">
        <i data-lucide="menu"></i>
    </button>
</nav>
