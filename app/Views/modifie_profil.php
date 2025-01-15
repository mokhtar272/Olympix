<div class="container mt-5">
    <h2 class="text-center mb-4">Modifier le Profil</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="post" action="<?php echo base_url('/index.php/compte/modifier_profil'); ?>">
    <?php if ($role === 'Jury'): ?>
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" name="nom" id="nom" class="form-control" value="<?php echo $jury['jry_nom']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" name="prenom" id="prenom" class="form-control" value="<?php echo $jury['jry_prenom']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="biographie" class="form-label">Biographie</label>
                <textarea name="biographie" id="biographie" rows="4" class="form-control"><?php echo $jury['jry_biographie']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="discipline" class="form-label">Discipline</label>
                <input type="text" name="discipline" id="discipline" class="form-control" value="<?php echo $jury['jry_discipline_expertise']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="url" class="form-label">URL</label>
                <input type="url" name="url" id="url" class="form-control" value="<?php echo $jury['jry_url']; ?>">
            </div>
        <?php endif; ?>

        <div class="mb-3">
            <label for="password" class="form-label">Nouveau Mot de Passe</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirmer le Mot de Passe</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control">
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success">Valider</button>
            <a href="<?php echo base_url('/index.php/compte/afficher_profil'); ?>" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
