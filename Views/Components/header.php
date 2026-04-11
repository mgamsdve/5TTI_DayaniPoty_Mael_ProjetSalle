<nav class="navbar">
    <!-- Marque du site et retour vers l'accueil. -->
    <a href="/" class="navbar-brand">
        <i data-lucide="building-2"></i>
        <span>RoomBook</span>
    </a>

    <!-- Zone centrale du menu, différente selon que l'utilisateur est connecté ou non. -->
    <div class="navbar-links" id="navbar-links">
        <a href="/">Accueil</a>
        <a href="/Salle">Salles</a>
        <a href="/Equipement">Équipements</a>
        <?php if (isset($_SESSION["user"])) : ?>
            <!-- Les réservations et la liste des utilisateurs sont visibles une fois connecté. -->
            <a href="/Reservation">Mes réservations</a>
            <a href="/Utilisateur">Utilisateurs</a>
            <?php if ($_SESSION["user"]->uti_role == "admin") : ?>
                <!-- Le sous-menu admin n'apparaît que pour les comptes ayant le rôle admin. -->
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

    <!-- Actions de droite: profil et connexion varient selon l'état de session. -->
    <div class="navbar-actions">
        <?php if (isset($_SESSION["user"])) : ?>
            <!-- Affiche les initiales pour identifier rapidement le compte connecté. -->
            <div class="navbar-user">
                <div class="navbar-avatar">
                    <?= strtoupper(substr($_SESSION["user"]->uti_prenom, 0, 1) . substr($_SESSION["user"]->uti_nom, 0, 1)) ?>
                </div>
                <span><?= htmlspecialchars($_SESSION["user"]->uti_prenom) ?></span>
            </div>
            <!-- Le profil et la déconnexion sont accessibles directement. -->
            <a href="/Profil" class="btn-outline-sm">Profil</a>
            <a href="/deconnexion" class="btn-sm">Déconnexion</a>
        <?php else : ?>
            <!-- Si personne n'est connecté, on propose les actions d'authentification. -->
            <a href="/connexion" class="btn-outline-sm">Connexion</a>
            <a href="/inscription" class="btn-sm">Inscription</a>
        <?php endif ?>
    </div>

    <!-- Bouton mobile qui ouvre ou ferme la navigation compacte. -->
    <button class="navbar-mobile-toggle"
        onclick="document.getElementById('navbar-links').classList.toggle('open')"
        aria-label="Menu">
        <i data-lucide="menu"></i>
    </button>
</nav>
