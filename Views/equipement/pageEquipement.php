<!-- Liste publique des équipements disponibles dans le système. -->
<h1>Équipements</h1>

<?php if (empty($equipements)) : ?>
    <!-- État vide si aucun équipement n'est encore enregistré. -->
    <p>Aucun équipement disponible pour le moment.</p>
<?php else : ?>
    <!-- Les équipements sont présentés sous forme de cartes simples. -->
    <div class="Salle-container">
        <?php foreach ($equipements as $equipement) : ?>
            <!-- Une carte montre le nom, la description et la référence. -->
            <div class="salle">
                <div class="equipement-icon">🛠️</div>
                <h3><?= htmlspecialchars($equipement->equi_nom) ?></h3>
                <?php if (!empty($equipement->equi_description)) : ?>
                    <!-- La description est optionnelle, donc on ne l'affiche que si elle existe. -->
                    <p><?= htmlspecialchars($equipement->equi_description) ?></p>
                <?php endif; ?>
                <!-- L'identifiant technique aide à retrouver l'enregistrement en base. -->
                <p class="equipement-id"><strong>Ref. :</strong> #<?= $equipement->id_equipement ?></p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
