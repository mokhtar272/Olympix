<div class="container mt-5" style="margin-bottom: 400px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4"><?= esc($titre); ?></h2>
            
            <!-- Affichage des messages flash -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= esc(session()->getFlashdata('error')); ?>
                </div>
            <?php endif; ?>

            <!-- Formulaire de connexion -->
            <?= form_open('/compte/connecter', ['class' => 'needs-validation', 'novalidate' => true]); ?>
            <?= csrf_field(); ?>
            
            <div class="form-group mb-3">
                <label for="pseudo" class="form-label">Pseudo</label>
                <input type="text" name="pseudo" id="pseudo" placeholder="Entrez le login" class="form-control" " required>
                <div class="text-danger">
                    <?= validation_show_error('pseudo'); ?>
                </div>
            </div>
            
            <div class="form-group mb-3">
                <label for="mdp" class="form-label">Mot de passe</label>
                <input type="password" name="mdp" id="mdp" class="form-control"  placeholder="Entrez le mot de passe"required>
                <div class="text-danger">
                    <?= validation_show_error('mdp'); ?>
                </div>
            </div>
            
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Se connecter</button>
            </div>
            
            </form>
        </div>
    </div>
</div>
