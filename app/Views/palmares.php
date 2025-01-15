<div class="container mt-5">
    <h1 class="text-center mb-5">🏆 Palmarès du Concours</h1>

    <?php if (!empty($palmares_par_categorie)): ?>
        <?php foreach ($palmares_par_categorie as $categorie => $candidats): ?>
            <div class="mb-5">
                <h2 class="text-center text-info mb-4">Catégorie : <?= esc($categorie) ?></h2> <!-- Couleur bleu clair -->
                <div class="row justify-content-center" style="margin-bottom: 100px;">
                    <?php foreach ($candidats as $index => $candidat): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card text-center shadow-lg h-100" style="border-radius: 15px;">
                                <div class="card-header bg-info text-white"> <!-- Couleur bleu clair -->
                                    <h3>
                                        <?= $index === 0 ? '🥇' : ($index === 1 ? '🥈' : '🥉') ?>
                                        <?= esc($candidat['nom']) ?> <?= esc($candidat['prenom']) ?>
                                    </h3>
                                </div>
                                <div class="card-body" style="background-color: #f0f8ff;"> <!-- Fond bleu pâle -->
                                    <p><strong>Email :</strong> <?= esc($candidat['email']) ?></p>
                                    <p><strong>Note Finale :</strong> <?= esc($candidat['note']) ?>/20</p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-info text-center">
            Aucun résultat disponible pour ce concours.
        </div>
    <?php endif; ?>
</div>
