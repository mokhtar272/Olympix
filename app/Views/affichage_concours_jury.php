<div class="container">
    <h2 class="mb-4">Liste des Concours</h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Phase</th>
                    <th>Titre</th>
                    <th style="width: 130px; word-wrap: break-word; white-space: normal;">Date de Début</th>
                    <th>Catégories</th>
                    <th>Jurys</th>
                    <th style="width: 130px; word-wrap: break-word; white-space: normal;">Dates</th>
                    <th>Email Organisateur</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($concours) && !empty($concours)): ?>
                    <?php foreach ($concours as $concour): ?>
                        <!-- Vérifiez si la phase est "Finale" -->
                        <?php if ($concour['phase_concours'] === 'Finale' && (int)$concour['galerie_accessible'] === 1): ?>
                            <!-- Ajoutez un lien cliquable pour toute la ligne -->
                            <tr class="table-info" onclick="window.location='<?= base_url('/index.php/candidatures/liste/' . esc($concour['id_concours'])) ?>'" style="cursor: pointer;">
                        <?php else: ?>
                            <!-- Ligne normale sans lien -->
                            <tr>
                        <?php endif; ?>
                            <td><?= esc($concour['phase_concours']) ?></td>
                            <td><?= esc($concour['titre']) ?></td>
                            <td style="width: 130px; word-wrap: break-word; white-space: normal;"><?= esc($concour['date_debut']) ?></td>
                            <td><?= esc($concour['categories']) ?></td>
                            <td><?= esc($concour['jurys']) ?></td>
                            <td style="width: 130px; word-wrap: break-word; white-space: normal;"><?= nl2br(esc($concour['dates'], 'raw')) ?></td>
                            <td><?= esc($concour['email_organisateur']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Aucun concours disponible</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


