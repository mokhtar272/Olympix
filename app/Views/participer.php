<div class="container mt-5" style="margin-bottom: 200px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Inscription du Candidat</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($validation)): ?>
                        <div class="alert alert-danger">
                            <?= $validation->listErrors(); ?>
                        </div>
                    <?php endif; ?>

                    <form
                        action="<?= isset($id_conc) ? base_url('/index.php/candidat/inscrire/' . esc($id_conc)) : '#' ?>"
                        method="post" enctype="multipart/form-data">

                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom :</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="<?= set_value('nom') ?>"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom :</label>
                            <input type="text" class="form-control" id="prenom" name="prenom"
                                value="<?= set_value('prenom') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email :</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?= set_value('email') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_email" class="form-label">Confirmer Email :</label>
                            <input type="email" class="form-control" id="confirm_email" name="confirm_email"
                                value="<?= set_value('confirm_email') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="documents" class="form-label">Documents associés (PDF uniquement) :</label>
                            <input type="file" class="form-control" id="documents" name="documents[]" accept=".pdf"
                                multiple required>
                        </div>
                        <div class="mb-3">
                            <?php if (!empty($categories)): ?>
                                <select name="categorie_concours">
                                    <option value="">Choisissez une catégorie</option>
                                    <?php foreach ($categories as $categorie): ?>
                                        <option value="<?= esc($categorie['ctg_idT_CATEGORIE_ctg']) ?>">
                                            <?= esc($categorie['ctg_nom']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else: ?>
                                <p class="text-danger">Aucune catégorie disponible pour ce concours.</p>
                            <?php endif; ?>

                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success">Soumettre</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Lien vers Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>