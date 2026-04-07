<div class="admin-layout">
    <?php require_once("Views/Components/admin-sidebar.php"); ?>
    <div class="admin-content">
        <?php if (!$userDetails): ?>
            <h1>Utilisateur introuvable</h1>
            <p class="mb-24">Le compte demande n'existe pas.</p>
            <a href="/admin/users" class="btn">Retour aux utilisateurs</a>
        <?php else: ?>
            <h1>Fiche utilisateur</h1>
            <a href="/admin/users" class="admin-back">
                <i data-lucide="arrow-left" class="icon-14"></i>
                Retour a la liste des utilisateurs
            </a>

            <div class="details-layout details-layout--spaced">
                <div class="details-main">
                    <div class="details-header">
                        <div class="details-avatar">
                            <?= strtoupper(substr($userDetails->uti_prenom, 0, 1) . substr($userDetails->uti_nom, 0, 1)) ?>
                        </div>
                        <div>
                            <h2 class="details-title"><?= htmlspecialchars($userDetails->uti_prenom . " " . $userDetails->uti_nom) ?></h2>
                            <span class="role <?= strtolower($userDetails->uti_role) ?>"><?= htmlspecialchars($userDetails->uti_role) ?></span>
                        </div>
                    </div>

                    <div class="details-info-row">
                        <p><strong>ID :</strong> #<?= $userDetails->id_utilisateur ?></p>
                        <p><strong>Email :</strong> <?= htmlspecialchars($userDetails->uti_email) ?></p>
                    </div>

                    <h2>Reservations de cet utilisateur</h2>
                    <?php if (empty($userReservations)): ?>
                        <p>Aucune reservation pour cet utilisateur.</p>
                    <?php else: ?>
                        <div class="reservation-list">
                            <?php foreach ($userReservations as $reservation): ?>
                                <div class="reservation-item">
                                    <i data-lucide="calendar" class="icon-16 icon-primary shrink-0"></i>
                                    <div>
                                        <strong><?= htmlspecialchars($reservation->sal_nom) ?> (<?= htmlspecialchars($reservation->sal_numero) ?>)</strong>
                                        &mdash;
                                        Du <?= htmlspecialchars($reservation->res_dateDebut) ?>
                                        au <?= htmlspecialchars($reservation->res_dateFin) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div>
                    <div class="booking-panel">
                            <h3>Modifier ce compte</h3>
                        <form method="GET" action="/admin/users">
                            <input type="hidden" name="action" value="updateUserGet">
                            <input type="hidden" name="id_utilisateur" value="<?= $userDetails->id_utilisateur ?>">

                            <label for="detail-user-nom">Nom</label>
                            <input type="text" id="detail-user-nom" name="nom" value="<?= htmlspecialchars($userDetails->uti_nom) ?>" required>

                            <label for="detail-user-prenom">Prenom</label>
                            <input type="text" id="detail-user-prenom" name="prenom" value="<?= htmlspecialchars($userDetails->uti_prenom) ?>" required>

                            <label for="detail-user-email">Email</label>
                            <input type="email" id="detail-user-email" name="email" value="<?= htmlspecialchars($userDetails->uti_email) ?>" required>

                            <label for="detail-user-role">Role</label>
                            <select id="detail-user-role" name="role">
                                <option value="utilisateur" <?= $userDetails->uti_role == "utilisateur" ? "selected" : "" ?>>utilisateur</option>
                                <option value="admin" <?= $userDetails->uti_role == "admin" ? "selected" : "" ?>>admin</option>
                            </select>

                            <input type="submit" value="Mettre a jour">
                        </form>

                        <form method="GET" action="/admin/users" class="mt-10" onsubmit="return confirm('Supprimer ce compte ?');">
                            <input type="hidden" name="action" value="deleteUserGet">
                            <input type="hidden" name="id_utilisateur" value="<?= $userDetails->id_utilisateur ?>">
                                <input type="submit" value="Supprimer cet utilisateur" class="btn btn-danger btn-block">
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
