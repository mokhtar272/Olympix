<div class="container">
    <h2 class="mb-4">Liste des Actualités</h2>
    <br>
    <h2 class="mb-4">Demo projet 2024!</h2>

    <?php if (isset($actualites) && !empty($actualites)): ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Titre</th>
                        <th>Texte</th>
                        <th>Date de Publication</th>
                        <th>Auteur</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($actualites as $index => $actualite): ?>
                        <tr>
                            <td><?= esc($actualite['act_titre']) ?></td>
                            <td><?= esc($actualite['act_texte']) ?></td>
                            <td><?= esc($actualite['act_date_pub']) ?></td>
                            <td><?= esc($actualite['cmp_e_mail']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center mt-4" role="alert">
            <strong>Aucune actualité disponible pour le moment</strong> 
        </div>
    <?php endif; ?>
</div>
