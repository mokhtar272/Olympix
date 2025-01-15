<div class="container mt-5">
    <h2 class="mb-4">Galerie des Candidatures Pré-Sélectionnées pour le Concours</h2>

    <?php if (!empty($candidatures)): ?>
        <?php
        // Regrouper les candidatures par catégorie
        $candidatures_par_categorie = [];
        foreach ($candidatures as $candidature) {
            $categorie = $candidature['categorie'];
            $candidatures_par_categorie[$categorie][] = $candidature;
        }
        ?>

        <?php foreach ($candidatures_par_categorie as $categorie => $candidats): ?>
            <div class="mb-5">
                <h3 class="text-primary"><?= esc($categorie) ?></h3>
                <div class="row">
                    <?php foreach ($candidats as $candidature): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title"><?= esc($candidature['nom']) ?> <?= esc($candidature['prenom']) ?></h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Email : <?= esc($candidature['email']) ?></h6>
                                    <p class="card-text">
                                        <strong>État :</strong> <?= esc($candidature['etat']) ?>
                                    </p>
                                    <div>
                                        <strong>Documents :</strong><br>
                                        <?php
                                        $documents = explode(',', esc($candidature['doc_nom']));
                                        foreach ($documents as $doc_nom):
                                            $doc_nom = trim($doc_nom);
                                            $chemin_fichier = base_url('images/' . $doc_nom);
                                            ?>
                                            <a href="<?= $chemin_fichier ?>" target="_blank"><?= $doc_nom ?></a><br>
                                        <?php endforeach; ?>
                                    </div>

                                    <!-- Affichage de la note attribuée -->
                                    <p class="mt-3"><strong>Note attribuée :</strong> 
                                        <?= esc($candidature['note'] ?? 'Non notée') ?>
                                    </p>

                                    <!-- Formulaire de notation -->
                                    <form action="<?= base_url('index.php/Candidature/attribuerNote') ?>" method="post">
                                        <input type="hidden" name="cnd_id" value="<?= esc($candidature['cnd_id']) ?>">
                                        <div class="form-group mt-3">
                                            <label for="note_<?= esc($candidature['cnd_id']) ?>">Attribuer ou modifier la Note (sur 5) :</label>
                                            <input type="number" class="form-control" name="note"
                                                id="note_<?= esc($candidature['cnd_id']) ?>" min="1" max="5"
                                                value="<?= esc($candidature['note'] ?? '') ?>" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-2">Soumettre</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-info text-center">
            Aucune candidature trouvée pour ce concours.
        </div>
    <?php endif; ?>
</div>
