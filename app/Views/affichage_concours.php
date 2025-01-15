<div class="container">
    <h2 class="mb-4">Liste des Concours</h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-dark">**
                <tr>
                    <th>Phase</th>
                    <th>Titre</th>
                    <th style="width: 130px; word-wrap: break-word; white-space: normal;">Date de Début</th>
                    <th>Catégories</th>
                    <th>Jurys</th>
                    <th style="width: 130px; word-wrap: break-word; white-space: normal;">dates</th>
                    <th>Email Organisateur</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($concours) && !empty($concours)): ?>
                    <?php foreach ($concours as $concour): ?>
                        <tr>
                            <td><?= esc($concour['phase_concours']) ?></td>
                            <td><?= esc($concour['titre']) ?></td>
                            <td style="width: 130px; word-wrap: break-word; white-space: normal;"><?= esc($concour['date_debut']) ?></td>
                            <td>
                                <?= esc($concour['categories'] ?? 'Aucune catégorie') ?>
                            </td>
                            <td>
                                <?= esc($concour['jurys'] ?? 'Aucun membre du jury') ?>
                            </td>
                            <td style="width: 130px; word-wrap: break-word; white-space: normal;"><?= nl2br(esc($concour['dates'], 'raw')) ?></td>
                            <td><?= esc($concour['email_organisateur']) ?></td>
                            <td class="text-center">
                                <a href="#" title="Voir les détails" class=" mx-2 ">
                                    <i class="fa-solid fa-magnifying-glass" style="color: #74C0FC;"></i>
                                </a>

                                

                                <?php if ($concour['phase_concours'] === 'Finale'): ?>
                                    <a href="<?= base_url('/index.php/candidatures/liste/' . esc($concour['id_concours'])) ?>" title="Candidatures sélectionnées">
                                        <i class="fas fa-user-check" style="color: #6C757D;"></i>
                                    </a>
                                <?php endif; ?>

                                <?php if ($concour['phase_concours'] === 'Terminé'): ?>
                                    <!-- Icône pour voir le palmarès -->
                                    <a href="<?= base_url('/index.php/Candidatures/palmares/' . esc($concour['id_concours'])) ?>" title="Voir le palmarès">
                                        <i class="fas fa-trophy" style="color: #FFD700;"></i>
                                    </a>
                                <?php endif; ?>

                                <?php if ($concour['phase_concours'] === 'inscription'): ?>
                                    <!-- Icône pour s'inscrire -->
                                    <a href="<?= base_url('/index.php/candidat/inscrire/' . esc($concour['id_concours'])) ?>" title="S'inscrire">
                                        <i class="fas fa-pen-alt"></i>
                                    </a> </a>
                                <?php endif; ?>
                            </td> 


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