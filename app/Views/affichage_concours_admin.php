<div class="container mt-5">
    <h2 class="mb-4">Liste des Concours</h2>
    <a href="<?= base_url('/index.php/concours/creer') ?>" class="btn btn-primary mb-3">Ajouter un concour</a>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Phase</th>
                    <th>Titre</th>
                    <th>Date de Début</th>
                    <th>Catégories</th>
                    <th>Jurys</th>
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
                            <td><?= esc($concour['date_debut']) ?></td>
                            <td>
                                <?= esc($concour['categories'] ?? 'Aucune catégorie') ?>
                            </td>
                            <td>
                                <?= esc($concour['jurys'] ?? 'Aucun membre du jury') ?>
                            </td>
                            <td><?= esc($concour['email_organisateur']) ?></td>
                            <td class="text-center">
                                <!-- Voir les détails -->
                                <a href="<?= base_url('/index.php/concours/details/' . $concour['id_concours']) ?>" title="Voir les détails">
                                    <i class="fa-solid fa-magnifying-glass m-2" style="color: #74C0FC;"></i>
                                </a>

                                <?php if ($concour['id_compte_organisateur'] === $id_compte && $concour['phase_concours'] === 'à venir' ): ?>


                                <a href="<?= base_url('/index.php/concours/supprimer/' . $concour['id_concours']) ?>" title="Supprimer concours" onclick="return confirm('Voulez-vous vraiment supprimer ce concours ?');" >
                                        <i class="fa-solid fa-trash m-2" style="color: #ff0000;"></i>                   
                                </a>

                                <?php endif; ?>

                                <!-- Candidatures -->
                                <?php if ($concour['phase_concours'] !== 'à venir' ): ?>
                                <a href="<?= base_url('/index.php/candidatures/liste/' . $concour['id_concours']) ?>" title="Voir les candidatures">
                                    <i class="fas fa-users m-2" style="color: #17A2B8;"></i>
                                </a>
                                <?php endif; ?>

                                <!-- Galerie des pré-sélectionnés -->
                                <?php if ($concour['phase_concours'] === 'Finale' ): ?>
                                    <a href="<?= base_url('/index.php/candidatures/liste/' . esc($concour['id_concours'])) ?>" title="Voir la galerie des pré-sélectionnés">
                                        <i class="fas fa-images m-2 " style="color: #6C757D;"></i>
                                    </a>
                                <?php endif; ?>

                                <!-- Palmarès -->
                                <?php if ($concour['phase_concours'] === 'Terminé'): ?>
                                    <a href="<?= base_url('/index.php/concours/palmares/' . $concour['id_concours']) ?>" title="Voir le palmarès">
                                        <i class="fas fa-trophy m-2" style="color: #FFD700;"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Aucun concours pour l'instant !</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
