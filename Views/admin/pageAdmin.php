<div class="admin-layout">
    <?php require_once("Views/Components/admin-sidebar.php"); ?>
    <div class="admin-content">
        <h1>Administration</h1>
        <p class="section-copy">Gérez toutes les ressources de l'application.</p>

        <div class="admin-search" role="search">
            <label for="admin-home-search-input">Rechercher un module</label>
            <input
                type="text"
                id="admin-home-search-input"
                placeholder="Utilisateurs, salles, réservations..."
                autocomplete="off"
            >
        </div>

        <div class="admin-kpi-grid">
            <div class="admin-kpi" data-search="utilisateurs comptes roles user">
                <div class="admin-kpi-icon"><i data-lucide="users"></i></div>
                <div class="admin-kpi-label">Utilisateurs</div>
                <p>Gérer les comptes et les rôles.</p>
                <a href="/admin/users" class="btn">Ouvrir</a>
            </div>
            <div class="admin-kpi" data-search="categories salles categorie">
                <div class="admin-kpi-icon"><i data-lucide="tag"></i></div>
                <div class="admin-kpi-label">Catégories</div>
                <p>Gérer les catégories des salles.</p>
                <a href="/admin/categories" class="btn">Ouvrir</a>
            </div>
            <div class="admin-kpi" data-search="salles salle infos">
                <div class="admin-kpi-icon"><i data-lucide="door-open"></i></div>
                <div class="admin-kpi-label">Salles</div>
                <p>Gérer les salles et leurs infos.</p>
                <a href="/admin/salles" class="btn">Ouvrir</a>
            </div>
            <div class="admin-kpi" data-search="equipements equipement materiel">
                <div class="admin-kpi-icon"><i data-lucide="monitor"></i></div>
                <div class="admin-kpi-label">Équipements</div>
                <p>Gérer les équipements disponibles.</p>
                <a href="/admin/equipements" class="btn">Ouvrir</a>
            </div>
            <div class="admin-kpi" data-search="contenances association equipements salles">
                <div class="admin-kpi-icon"><i data-lucide="link-2"></i></div>
                <div class="admin-kpi-label">Contenances</div>
                <p>Associer équipements et salles.</p>
                <a href="/admin/contenances" class="btn">Ouvrir</a>
            </div>
            <div class="admin-kpi" data-search="reservations reservation calendrier">
                <div class="admin-kpi-icon"><i data-lucide="calendar"></i></div>
                <div class="admin-kpi-label">Réservations</div>
                <p>Gérer toutes les réservations.</p>
                <a href="/admin/reservations" class="btn">Ouvrir</a>
            </div>
        </div>

        <p id="admin-home-no-results" class="admin-no-results" hidden>Aucun module ne correspond à votre recherche.</p>
    </div>
</div>

<script>
    initSearchFilter({
        inputSelector: "#admin-home-search-input",
        itemSelector: ".admin-kpi-grid .admin-kpi",
        emptySelector: "#admin-home-no-results"
    });
</script>
