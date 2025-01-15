<div class="container mt-5">
    <h2 class="mb-4">Gestion des Comptes</h2>
    <a href="<?= base_url('/index.php/compte/creer') ?>" class="btn btn-primary mb-3">Ajouter un compte</a>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Login</th>
                    <th>Rôle</th>
                    <th>État</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($comptes as $compte): ?>
                    <tr>
                        <td><?= esc($compte['email']) ?></td>
                        <td><?= esc(ucfirst($compte['role'])) ?></td>
                        <td>
                            <?= $compte['etat'] === '1' 
                                ? '<span class="badge bg-success">Actif</span>' 
                                : '<span class="badge bg-secondary">Désactivé</span>' ?>
                        </td>
                        <td>
                            <a href="<?= base_url('/index.php/compte/modifier_profil/' . $compte['id_compte']) ?>" class="btn btn-warning btn-sm">Modifier</a>

                            <?php if ($compte['email'] !== 'organisateur@gmail.com'): ?>
                                <?php if ($compte['etat'] === '1'): ?>
                                    <!-- Désactiver -->
                                    <a href="<?= base_url('/index.php/compte/desactiver/' . $compte['id_compte']) ?>" 
                                       onclick="return confirm('Voulez-vous vraiment désactiver ce compte ?');" 
                                       class="btn btn-danger btn-sm">
                                       Désactiver
                                    </a>
                                <?php else: ?>
                                    <!-- Activer -->
                                    <a href="<?= base_url('/index.php/compte/activer/' . $compte['id_compte']) ?>" 
                                       onclick="return confirm('Voulez-vous vraiment activer ce compte ?');" 
                                       class="btn btn-success btn-sm">
                                       Activer
                                    </a>
                                <?php endif; ?>

                                <!-- Supprimer -->
                                <a href="<?= base_url('/index.php/compte/supprimer/' . $compte['id_compte']) ?>" 
                                   onclick="return confirm('Voulez-vous vraiment supprimer ce compte ?');" 
                                   class="btn btn-danger btn-sm">
                                   Supprimer
                                </a>
                            <?php else: ?>
                                <!-- Désactiver/Supprimer désactivé pour l'organisateur -->
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
