<div class="container mt-5" style="margin-bottom: 400px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Suivi de Candidature</h2>

            <!-- Affichage des messages d'erreur -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= esc(session()->getFlashdata('error')); ?>
                </div>
            <?php endif; ?>

            <form action="<?php echo base_url('/index.php/candidature/afficher'); ?>" method="post">
                <?= csrf_field(); ?>

                <div class="form-group mb-3">
                    <label for="code_inscription">Code d'inscription</label>
                    <input type="text" name="code_inscription" id="code_inscription" placeholder="Entrez le code d'inscription" class="form-control" required>
                    <!-- Afficher l'erreur si elle existe -->
                    <div class="text-danger">
                        <?= validation_show_error('code_inscription'); ?>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="code_candidat">Code candidat</label>
                    <input type="text" name="code_candidat" id="code_candidat" placeholder="Entrez le code candidat" class="form-control" required>
                    <!-- Afficher l'erreur si elle existe -->
                    <div class="text-danger">
                        <?= validation_show_error('code_candidat'); ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Valider</button>
                <a href="<?php echo base_url('/'); ?>" class="btn btn-secondary">Retour</a>
            </form>
        </div>
    </div>
</div>
